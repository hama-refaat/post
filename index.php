<?php
set_time_limit(0);
ini_set('max_execution_time', 0);
class Colors {
  
private $foreground_colors = array();
private $background_colors = array();
public function __construct() {
$this->foreground_colors['black'] = '0;30';
$this->foreground_colors['dark_gray'] = '1;30';
$this->foreground_colors['blue'] = '0;34';
$this->foreground_colors['light_blue'] = '1;34';
$this->foreground_colors['green'] = '0;32';
$this->foreground_colors['light_green'] = '1;32';
$this->foreground_colors['cyan'] = '0;36';
$this->foreground_colors['light_cyan'] = '1;36';
$this->foreground_colors['red'] = '0;31';
$this->foreground_colors['light_red'] = '1;31';
$this->foreground_colors['purple'] = '0;35';
$this->foreground_colors['light_purple'] = '1;35';
$this->foreground_colors['brown'] = '0;33';
$this->foreground_colors['yellow'] = '1;33';
$this->foreground_colors['light_gray'] = '0;37';
$this->foreground_colors['white'] = '1;37';
$this->background_colors['black'] = '40';
$this->background_colors['red'] = '41';
$this->background_colors['green'] = '42';
$this->background_colors['yellow'] = '43';
        $this->background_colors['blue'] = '44';
        $this->background_colors['magenta'] = '45';
        $this->background_colors['cyan'] = '46';
        $this->background_colors['light_gray'] = '47';
    }
    public function color($string, $foreground_color = null, $background_color = null) {
        $colored_string = "";
        if (isset($this->foreground_colors[$foreground_color])) {
            $colored_string.= "\033[" . $this->foreground_colors[$foreground_color] . "m";
        }
        if (isset($this->background_colors[$background_color])) {
            $colored_string.= "\033[" . $this->background_colors[$background_color] . "m";
        }
        $colored_string.= $string . "\033[0m";
        print ($colored_string);
    }
}
if (php_sapi_name() !== "cli") {
    die("Only on cli mode");
}
$print = new Colors();
function bot($method, $datas = []) {
    global $token;
    $url = "https://api.telegram.org/bot" . $token . "/" . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
}
function cin($a) {
return gmdate("H:i:s", str_replace("-", null, explode(".", ($a - microtime(true))) [0]));
}
empty($argv[1]) ? die("Tkaya kara bkawa:\n php " . $argv[0] . " \"TEXT MESSAGE\"\n") : null;
mb_strlen($argv[1]) > 4096 ? die("Bbwra token hallaya" . mb_strlen($argv[1]) . "\n") : null;
$token = readline("Token bnwsa : ");
@$bot = bot('Getme');
if (!$bot->ok) {
$token = readline("Token hallaya tkaya dwbara hawll bdawa: ");
@$bot = bot('Getme');
}
$bot->ok ? null : die("Bad Token . exit \n");
$print->color("===========BOTI Hama Refaat==========\n", 'yellow', 'black');
$printedtext = "ID: " . $bot->result->id . "\n";
$printedtext.= "Name: " . $bot->result->first_name . "\n";
$printedtext.= "User: @" . $bot->result->username . "\n";
$print->color($printedtext, "cyan", "black");
$print->color("========================\n", 'yellow', 'black');
$path = readline("esta linke file hallgrtni id bakahernakan dani: ");
if (filter_var($path, FILTER_SANITIZE_URL)) {
$filename = end(explode("/", $path));
$print->color("Downloading " . $filename . "\n", 'yellow', 'black');
copy($path, $filename) ? print ("File Downloaded\n") : die(print ("hallaya nawtanm dabazinm " . $filename . "\n"));
$path = $filename;
}
if (!file_exists($path)) {
$path = readline("hallaya " . $path . " linke nasnamay andakant dwbara dani: ");
}
file_exists($path) ? null : die($path . " File Not exists . exit\n");
$requset = file_get_contents($path);
$ids = Array();
if (end(explode(".", $path)) == "json") {
$ids = json_decode($requset, 1);
$name = array_keys($ids) [0];
if (!is_numeric($name)) {
  $ids = $ids[$name];
}
} elseif (end(explode(".", $path)) == "txt") {
$ids = explode("\n", $requset);
}
empty($ids[1]) ? die("Eta linke faile hallgri id andamakant dai " . $path . "\n") : null;
 $count = count($ids);
 $fail = Array();
 system("clear");
 $print->color("Nardni nama dasy pe krd bo " . $count . " id's\n", "cyan", "black");
 $start = microtime(true);
 for ($x = 0;$x < count($ids);$x++) {
 if (!is_numeric($ids[$x])) continue;
 @$res = bot('sendmessage', ['chat_id' =>$ids[$x],'text' => $argv[1], 'parse_mode' => 'MARKDOWN'])->ok;
 if (!$res) {
 print ($x . " > Natwanm nama bnirm bo: " . $ids[$x] . "\n");
 $fail[] = $ids[$x];
 } elseif ($res) {
 $print->color($x . " > nama nardra boy: " . $ids[$x] . "\n", "light_green", "black");
 }
 //time_nanosleep(0, 500000000);
  
}
$a = array_values(array_diff($ids, $fail));
file_exists($bot->result->username . ".json") ? unlink($bot->result->username . ".json") : null;
file_put_contents($bot->result->username . ".json", json_encode($a, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK), LOCK_EX);
$result = "nardni nama taw bw:\n";
$result.= "BOT: " . $bot->result->username . ", " . $path . "\n";
$result.= "Hamw andamakan: " . $count . "\n";
$result.= "Namaian bo chwa: " . count($a) . "\n";
$result.= "Namaian Bo nachwa: " . count($fail) . "\n";
$result.= "Tawaw bw kat: " . cin($start) . "\n";
$result.= "by @hama_refaat ~ @hama_roberts \n";
$print->color($result, "cyan", "black");
