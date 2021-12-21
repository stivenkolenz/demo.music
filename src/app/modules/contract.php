<?php

$SQL = "SELECT * FROM `user_data` WHERE `user_id` = '{$user['id']}';";
$res = $DB->qf_array($SQL, 1);

if ((empty($res) ? true : false)) {
    $F->loc("/r/{$request_id}/step/3/", $lang['notdata3']);
} else {
    $data = [];
    foreach ($res as $key => $value) {
        $data[$value['field']] = $value['value'];
    }

    $data['fn'] = mb_substr($data['firstname'], 0, 1);
    $data['sn'] = mb_substr($data['secondname'], 0, 1);

    $SQL = "SELECT `value` FROM `values` WHERE `request_id` = '{$request_id}' AND `step_id` = '1' AND `field` = 'nickname';";
    $res = $DB->qf_assoc($SQL, 1);
    $data['nickname'] = $res['value'];

    
    // $F->pre($data);
    // $file_name = md5($data['Фамилия'].' '.$data['Имя'].' '.$data['Отчество']);
    $file_hash = md5($user['id'].$request_id);
    $file_name = 'u'.$user['id'].'r'.$request_id.'h'.$file_hash;
    // $F->pre($file_name);
    $file = ROOT.'/upload/contract/'.$file_name.'.docx';
    // $F->pre($file);
    if ( file_exists($file) ) {
        $F->file_force_download($file);
    } else {
        require_once 'vendor/autoload.php';

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $doc = $phpWord->loadTemplate(ROOT.'/upload/contract/_contract_template.docx'); 
        foreach ($data as $key => $value) {
            $doc->setValue( $key, $value );
        }

        $OGRNIPINN = '';
        if ( $data['type'] == 'Физ лицо' ) {
            $OGRNIPINN.='ИНН '. $data['INN'];
        }else {
            $OGRNIPINN.='ОГРНИП '. $data['OGRNIP'];
        }
        $doc->setValue( 'OGRNIPINN', $OGRNIPINN );
        $doc->saveAs($file);
        $F->file_force_download($file);
    }
    unlink($file);
    die();
    // $F->pre($data);
}