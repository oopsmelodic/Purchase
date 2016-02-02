<?php

class Model_User extends Model{
    public function show_file($id){
        include_once './php/conn.php';
        $sql = "Select public_url,id,filename,type,filepath,file_lang,processed,title,length_record,date_upload,peaks From dbfilenames Where id='".$id."'";
        $result = mysql_query($sql);
        if ($result) {
            while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
                if ($row['processed']==4){
                    $db['meta']=$row;
                    $sql1 = "Select id,timestart,timeend,text,alttext,speakerid From dbfilestext Where fileid='".$id."' Order by timestart";
                    $result1= mysql_query($sql1);
                    if ($result1){
                       while ($row1 = mysql_fetch_array($result1,MYSQL_ASSOC)) {
                           $db['text'][] = $row1;                           
                       }
                    }
                }else{
                    $db['meta']=$row;
                }
            }
            return $db;
        }          
    }
    
    
    public function getSettings($userid){
        include_once './php/conn.php';
        $sql = "Select * From dbusers Where id='".$userid."'";
        $row = mysql_fetch_array(mysql_query($sql)) ;
        if ($row) {            
            return $row;
        }                 
    }

    
    public function saveSettings($userid,$settings){
        extract($settings);
        $search_word =  array_key_exists('search_word',$settings) ? 1 : 0;
        include_once './php/conn.php';
        $sql = "Update dbusers set ";
        foreach ($settings as $key => $value) {
            if ($key=="search_word"){
                $value =  $search_word;
            }
            $sql.=$key."='".$value."' ";
        }
        if ($search_word==0){
            $sql.="search_word='".$search_word."' ";
        }
        $sql.=  "Where id='".$userid."'";
        $sql = "Update dbusers set login='".$login."', pwd='".$pwd."', email='".$email."', search_word=".$search_word.", words='".$words."' Where id='".$userid."'";
        $result = mysql_query($sql);
        return $result;              
    }
}
