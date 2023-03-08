<?php

function linuxFilename($file)
{
	return preg_replace("/ |'|\(|\)/", '\\\${0}', $file);
}

function replace_extension($filename, $new_extension)
{
	$info = pathinfo($filename);
	return $info['filename'] . '.' . $new_extension;
}

function get_title_and_times($str)
{
	$data = array(
		'title' => null,
		'times_string' => null
	);

	$values = array();
	preg_match('/(\d{1,2}.\d{1,2}, +|\d{1,2}.\d{1,2}+)+/', $str, $values);
	$title = trim(preg_replace('/(\d{1,2}.\d{1,2}, +|\d{1,2}.\d{1,2}+)+/', "", $str));

	$data['title'] = $title;

	if (empty($values[0])) {
		$data['times_string'] = "";
	} else {
		$data['times_string'] = $values[0];
	}

	return $data;
}

function parse_tv_programm_file($url_path)
{
	$zip = new ZipArchive();
	$zip->open($url_path);

	$zip->extractTo(__DIR__ . '/tmp/');
	$entries = $zip->count();

	for ($i = 0; $i < $entries; $i++) {
		$stat = $zip->statIndex($i);
		$fileContent = null;
		$status = NULL;

		$cmd = '/usr/local/bin/docx2txt < ' . __DIR__ . "/tmp/'" . $stat['name'] . "'";
		exec($cmd, $fileContent);

		if ($fileContent === NULL || !is_array($fileContent)) return;

		$channels = [];

		for ($j = 1; $j < count($fileContent); $j++) {
			$line = $fileContent[$j];
			if ($line != '') {
				if (preg_match('/^[a-zA-Zа-яА-Я.!()].*|5 International/', $line)) {
					$channels[] = [
						'title' => $line,
						'name' => sanitize_file_name($line),
						'img' => preg_replace("/(\.)/", '', trim($line, ".")) . '.png',
						'start_from' => $j,
						'programms' => []
					];
				}
			}
		}

		$length = count($channels) - 1;

		for ($x = 0; $x <= $length; ++$x) {
			$start_from = $channels[$x]['start_from'] + 1;
			$end_of = !empty($channels[$x + 1]) ? $channels[$x + 1]['start_from'] - 1 : count($fileContent) - 1;

			if ($start_from === $end_of) {
				$end_of += 1;
			}

			$sliced = array_slice($fileContent, $start_from, ($end_of) - $start_from);

			foreach ($sliced as $slice) {
				$prog = get_title_and_times($slice);
				array_push($channels[$x]['programms'], $prog);
			}
		}

		$fname = &$stat['name'];

		mb_regex_encoding('UTF-8');

		$fname = mb_ereg_replace('янва.{0,}\.docx', 'январь', $fname);
		$fname = mb_ereg_replace('февр.{0,}\.docx', 'февраль', $fname);
		$fname = mb_ereg_replace('март.{0,}\.docx', 'март', $fname);
		$fname = mb_ereg_replace('апре.{0,}\.docx', 'апрель', $fname);
		$fname = mb_ereg_replace('май.{0,}\.docx', 'май', $fname);
		$fname = mb_ereg_replace('июн.{0,}\.docx', 'июнь', $fname);
		$fname = mb_ereg_replace('июл.{0,}\.docx', 'июль', $fname);
		$fname = mb_ereg_replace('авгу.{0,}\.docx', 'август', $fname);
		$fname = mb_ereg_replace('сент.{0,}\.docx', 'сентябрь', $fname);
		$fname = mb_ereg_replace('октя.{0,}\.docx', 'октябрь', $fname);
		$fname = mb_ereg_replace('нояб.{0,}\.docx', 'ноябрь', $fname);
		$fname = mb_ereg_replace('дека.{0,}\.docx', 'декабрь', $fname);

		$fh = fopen(__DIR__ . '/output/' . replace_extension(sanitize_file_name(mb_strtolower($fname)), 'json'), 'w');

		$json = json_encode($channels, JSON_UNESCAPED_UNICODE);
		fwrite($fh, $json, strlen($json));
		fclose($fh);
	}

	$zip->close();
}

function get_day_list($file_name_date)
{
	$f_path = __DIR__ . '/output/' . $file_name_date . '.json';

	$fh = fopen($f_path, 'r');
	$content = json_decode(fread($fh, filesize($f_path)));
	fclose($fh);

	return $content;
}
