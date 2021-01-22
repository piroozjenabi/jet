<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Update_lib
{

    public function do_update()
    {
        ini_set('max_execution_time', 60);
        //Check For An Update
        $CI =& get_instance();
        $server_update=$CI->system->get_setting("update_link");
        $getVersions = file_get_contents("$server_update/release-versions.php") or die('ERROR');
        $cur_loc=getcwd();
        $server_root=getcwd();
        $curent_version=(int)$CI->system->get_setting("curent_version");
        if ($getVersions != '') {
            echo "<p>"._VERSION._CURRENT." :$curent_version</p>";

            $versionList = explode("\n", $getVersions);


            foreach ($versionList as $aV)
            {
                if ($aV > $curent_version) {
                    echo '<p>'._FOUND_NEW_VERSION. ': '.$aV.'</p>';
                    $found = true;
                    //Download The File If We Do Not Have It
                    if (!is_file($cur_loc.'/UPDATES/pierocrm-'.$aV.'.zip')) {
                        echo '<p>'._GET_NEW_UPDATE.'</p>';
                        $newUpdate = file_get_contents($server_update.'/pierocrm-'.$aV.'.zip');
                        if (!is_dir($cur_loc.'/UPDATES/') ) { mkdir($cur_loc.'/UPDATES/');
                        }
                        $dlHandler = fopen($cur_loc.'/UPDATES/pierocrm-'.$aV.'.zip', 'w');
                        if (!fwrite($dlHandler, $newUpdate) ) { echo '<p>عدم توانایی ذخیره فایلها</p>'; exit();
                        }
                        fclose($dlHandler);
                        echo '<p>'._LAST_VERSION_DOWNLOADED.'</p>';
                    } else { echo '<p>'._LAST_VERSION_IS_THERE.'</p>';
                    }

                    if ($_GET['doUpdate'] == true) {
                        //Open The File And Do Stuff
                        $zipHandle = zip_open($cur_loc.'/UPDATES/pierocrm-'.$aV.'.zip');
                        echo '<ul>';
                        while ($aF = zip_read($zipHandle) )
                        {
                            $thisFileName = zip_entry_name($aF);
                            $thisFileDir = dirname($thisFileName);

                            //Continue if its not a file
                            if (substr($thisFileName, -1, 1) == '/') { continue;
                            }


                            //Make the directory if we need to...
                            if (!is_dir($server_root.'/'.$thisFileDir) ) {
                                mkdir($server_root.'/'.$thisFileDir);
                                echo '<li>'._MAKE_FOLDER.' '.$thisFileDir.'</li>';
                            }

                            //Overwrite the file
                            if (!is_dir($server_root.'/'.$thisFileName) ) {
                                echo '<li>'.$thisFileName.'...........';
                                $contents = zip_entry_read($aF, zip_entry_filesize($aF));
                                $contents = str_replace("\r\n", "\n", $contents);
                                $updateThis = '';

                                //If we need to run commands, then do it.
                                if ($thisFileName == 'upgrade.php' ) {
                                    $upgradeExec = fopen('upgrade.php', 'w');
                                    fwrite($upgradeExec, $contents);
                                    fclose($upgradeExec);
                                    include 'upgrade.php';
                                    unlink('upgrade.php');
                                    echo _RUNED.' </li>';
                                }
                                else
                                {
                                    $updateThis = fopen($server_root.'/'.$thisFileName, 'w');
                                    fwrite($updateThis, $contents);
                                    fclose($updateThis);
                                    unset($contents);
                                    echo _UPDATED.' </li>';
                                }
                            }
                        }
                        echo '</ul>';
                        $updated = true;
                    }
                    else { echo '<p>'._ARE_YOU_READY_FOR_UPDATE.' <a class="btn btn-primary" href="?doUpdate=true">Update</a></p>';
                    }
                    break;
                }
            }

            if ($updated == true) {

                echo '<p class="success">'._UPDATED_DONE_TO." : ".$aV.'</p>';
            }
            else if ($found != true) { echo '<p>'._UPDATED_NOT_FOUND.'</p>';
            }


        }
        else { echo '<p>'._SERVER_NOT_FOUND.'</p>';
        }



    }
}
