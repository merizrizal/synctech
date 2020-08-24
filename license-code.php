<?php

function crypto($action, $string) {

	$output = false;

	$encrypt_method = "AES-256-CBC";

	$secret_key = 'stimulate your nerve';
	$secret_iv = 'this is synctech.id';

	// hash
	$key = hash('sha256', $secret_key);

	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	if ($action == 'encrypt') {

		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
	} else if ($action == 'decrypt') {

		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	}

	return $output;
}

$post = $_POST; 
$kodeLisensi = '';
if (!empty($post['kdRegistrasi'])) {
    
    $kodeLisensi = crypto('encrypt', $post['kdRegistrasi']);    
    $kodeLisensi .= '57nc' . crypto('encrypt', $post['jmlHari'] * 24 * 60 * 60);
}
?>

<form action="" method="POST">
<div class="form-group field-loginform-username required">
    <label class="control-label" for="kdRegistrasi">Kode Registrasi</label>
    <input type="text" id="kdRegistrasi" class="form-control" name="kdRegistrasi" value="<?= !empty($post['kdRegistrasi']) ? $post['kdRegistrasi'] : '' ?>" style="width: 380px">
    <p class="help-block help-block-error"></p>
</div>
<div class="form-group field-loginform-username required">
    <label class="control-label" for="jmlHari">Jumlah Hari</label>
    <input type="text" id="jmlHari" class="form-control" name="jmlHari" value="<?= !empty($post['jmlHari']) ? $post['jmlHari'] : '' ?>" style="width: 380px">
    <p class="help-block help-block-error"></p>
</div>
<div class="form-group field-loginform-username required">
    <label class="control-label" for="kdLisensi">Kode Lisensi</label>
    <input type="text" id="kdLisensi" class="form-control" name="kdLisensi" value="<?= $kodeLisensi ?>" style="width: 640px" readonly="readonly">
    <p class="help-block help-block-error"></p>
</div>

<button type="submit" value="submit">Submit</button>
</form>
