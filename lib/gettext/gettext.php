<?php

class gettext_reader {
  //public:
   var $error = 0; // public variable that holds error code (0 if no error)

   //private:
  var $BYTEORDER = 0;        // 0: low endian, 1: big endian
  var $STREAM = NULL;
  var $short_circuit = false;
  var $enable_cache = false;
  var $originals = NULL;      // offset of original table
  var $translations = NULL;    // offset of translation table
  var $pluralheader = NULL;    // cache header field for plural forms
  var $total = 0;          // total string count
  var $table_originals = NULL;  // table for original strings (offsets)
  var $table_translations = NULL;  // table for translated strings (offsets)
  var $cache_translations = NULL;  // original -> translation mapping


  public function readint() {
      if ($this->BYTEORDER == 0) {
        // low endian
        $input=unpack('V', $this->STREAM->read(4));
        return array_shift($input);
      } else {
        // big endian
        $input=unpack('N', $this->STREAM->read(4));
        return array_shift($input);
      }
    }

  public function read($bytes) {
    return $this->STREAM->read($bytes);
  }

  public function readintarray($count) {
    if ($this->BYTEORDER == 0) {
        // low endian
        return unpack('V'.$count, $this->STREAM->read(4 * $count));
      } else {
        // big endian
        return unpack('N'.$count, $this->STREAM->read(4 * $count));
      }
  }

  public function __construct($Reader, $enable_cache = true) {
    // If there isn't a StreamReader, turn on short circuit mode.
    if (! $Reader || isset($Reader->error) ) {
      $this->short_circuit = true;
      return $Reader;
    }

    // Caching can be turned off
    $this->enable_cache = $enable_cache;

    $MAGIC1 = "\x95\x04\x12\xde";
    $MAGIC2 = "\xde\x12\x04\x95";

    $this->STREAM = $Reader;
    $magic = $this->read(4);
    if ($magic == $MAGIC1) {
      $this->BYTEORDER = 1;
    } elseif ($magic == $MAGIC2) {
      $this->BYTEORDER = 0;
    } else {
      $this->error = 1; // not MO file
      return false;
    }

    $revision = $this->readint();

    $this->total = $this->readint();
    $this->originals = $this->readint();
    $this->translations = $this->readint();
  }

  public function load_tables() {
    if (is_array($this->cache_translations) &&
      is_array($this->table_originals) &&
      is_array($this->table_translations))
      return;

    /* get original and translations tables */
    if (!is_array($this->table_originals)) {
      $this->STREAM->seekto($this->originals);
      $this->table_originals = $this->readintarray($this->total * 2);
    }
    if (!is_array($this->table_translations)) {
      $this->STREAM->seekto($this->translations);
      $this->table_translations = $this->readintarray($this->total * 2);
    }

    if ($this->enable_cache) {
      $this->cache_translations = array ();
      /* read all strings in the cache */
      for ($i = 0; $i < $this->total; $i++) {
        $this->STREAM->seekto($this->table_originals[$i * 2 + 2]);
        $original = $this->STREAM->read($this->table_originals[$i * 2 + 1]);
        $this->STREAM->seekto($this->table_translations[$i * 2 + 2]);
        $translation = $this->STREAM->read($this->table_translations[$i * 2 + 1]);
        $this->cache_translations[$original] = $translation;
      }
    }
  }

  public function get_original_string($num) {
    $length = $this->table_originals[$num * 2 + 1];
    $offset = $this->table_originals[$num * 2 + 2];
    if (! $length)
      return '';
    $this->STREAM->seekto($offset);
    $data = $this->STREAM->read($length);
    return (string)$data;
  }

  public function get_translation_string($num) {
    $length = $this->table_translations[$num * 2 + 1];
    $offset = $this->table_translations[$num * 2 + 2];
    if (! $length)
      return '';
    $this->STREAM->seekto($offset);
    $data = $this->STREAM->read($length);
    return (string)$data;
  }

  public function find_string($string, $start = -1, $end = -1) {
    if (($start == -1) or ($end == -1)) {
      // find_string is called with only one parameter, set start end end
      $start = 0;
      $end = $this->total;
    }
    if (abs($start - $end) <= 1) {
      // We're done, now we either found the string, or it doesn't exist
      $txt = $this->get_original_string($start);
      if ($string == $txt)
        return $start;
      else
        return -1;
    } else if ($start > $end) {
      // start > end -> turn around and start over
      return $this->find_string($string, $end, $start);
    } else {
      // Divide table in two parts
      $half = (int)(($start + $end) / 2);
      $cmp = strcmp($string, $this->get_original_string($half));
      if ($cmp == 0)
        // string is exactly in the middle => return it
        return $half;
      else if ($cmp < 0)
        // The string is in the upper half
        return $this->find_string($string, $start, $half);
      else
        // The string is in the lower half
        return $this->find_string($string, $half, $end);
    }
  }

  public function translate($string) {
    if ($this->short_circuit)
      return $string;
    $this->load_tables();

    if ($this->enable_cache) {
      // Caching enabled, get translated string from cache
      if (array_key_exists($string, $this->cache_translations))
        return $this->cache_translations[$string];
      else
        return $string;
    } else {
      // Caching not enabled, try to find string
      $num = $this->find_string($string);
      if ($num == -1)
        return $string;
      else
        return $this->get_translation_string($num);
    }
  }

  public function sanitize_plural_expression($expr) {
    // Get rid of disallowed characters.
    $expr = preg_replace("@[^a-zA-Z0-9_:;\(\)\?\|\&=!<>+*/\%-]@", '', $expr);

    // Add parenthesis for tertiary '?' operator.
    $expr .= ';';
    $res = '';
    $p = 0;
    for ($i = 0; $i < strlen($expr); $i++) {
      $ch = $expr[$i];
      switch ($ch) {
      case '?':
        $res .= ' ? (';
        $p++;
        break;
      case ':':
        $res .= ') : (';
        break;
      case ';':
        $res .= str_repeat( ')', $p) . ';';
        $p = 0;
        break;
      default:
        $res .= $ch;
      }
    }
    return $res;
  }

  public function extract_plural_forms_header_from_po_header($header) {
    if (preg_match("/(^|\n)plural-forms: ([^\n]*)\n/i", $header, $regs))
      $expr = $regs[2];
    else
      $expr = "nplurals=2; plural=n == 1 ? 0 : 1;";
    return $expr;
  }

  public function get_plural_forms() {
    // lets assume message number 0 is header
    // this is true, right?
    $this->load_tables();

    // cache header field for plural forms
    if (! is_string($this->pluralheader)) {
      if ($this->enable_cache) {
        $header = $this->cache_translations[""];
      } else {
        $header = $this->get_translation_string(0);
      }
      $expr = $this->extract_plural_forms_header_from_po_header($header);
      $this->pluralheader = $this->sanitize_plural_expression($expr);
    }
    return $this->pluralheader;
  }

  public function select_string($n) {
    if (!is_int($n)) {
      throw new InvalidArgumentException(
        "Select_string only accepts integers: " . $n);
    }
    $string = $this->get_plural_forms();
    $string = str_replace('nplurals',"\$total",$string);
    $string = str_replace("n",$n,$string);
    $string = str_replace('plural',"\$plural",$string);

    $total = 0;
    $plural = 0;

    eval("$string");
    if ($plural >= $total) $plural = $total - 1;
    return $plural;
  }

  public function ngettext($single, $plural, $number) {
    if ($this->short_circuit) {
      if ($number != 1)
        return $plural;
      else
        return $single;
    }

    // find out the appropriate form
    $select = $this->select_string($number);

    // this should contains all strings separated by NULLs
    $key = $single . chr(0) . $plural;


    if ($this->enable_cache) {
      if (! array_key_exists($key, $this->cache_translations)) {
        return ($number != 1) ? $plural : $single;
      } else {
        $result = $this->cache_translations[$key];
        $list = explode(chr(0), $result);
        return $list[$select];
      }
    } else {
      $num = $this->find_string($key);
      if ($num == -1) {
        return ($number != 1) ? $plural : $single;
      } else {
        $result = $this->get_translation_string($num);
        $list = explode(chr(0), $result);
        return $list[$select];
      }
    }
  }

  public function pgettext($context, $msgid) {
    $key = $context . chr(4) . $msgid;
    $ret = $this->translate($key);
    if (strpos($ret, "\004") !== FALSE) {
      return $msgid;
    } else {
      return $ret;
    }
  }

  public function npgettext($context, $singular, $plural, $number) {
    $key = $context . chr(4) . $singular;
    $ret = $this->ngettext($key, $plural, $number);
    if (strpos($ret, "\004") !== FALSE) {
      return $singular;
    } else {
      return $ret;
    }

  }
}

