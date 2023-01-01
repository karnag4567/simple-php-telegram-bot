<?php

date_default_timezone_set('America/Lima');

#FUNCION PARA ENVIAR MENSAJES
    
    function EnviarMensaje($chatId, $message, $message_id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org:443/bot'.$GLOBALS['botToken'].'/sendMessage');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'HTTP/1.1 200 OK'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"chat_id":"'.$chatId.'","text":"'.$message.'","reply_to_message_id":"'.$message_id.'","parse_mode":"HTML"}');
        $result = curl_exec($ch);
    }

#FUNCION PARA AÑADIR CHAT-IDs(USUARIOS O GRUPOS)
    
    function VerificarAdmin($userId)
    {
        $file = array_values(array_unique(file('Users/Admins.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
        foreach ($file as $key => $value) {
            if ($value == $userId) {
                $Admin = true;
                $GLOBALS['Admin'] = $Admin;
                break;
            } else {
                $Admin = false;
                $GLOBALS['Admin'] = $Admin;
            }
        }
    }

#FUNCION PARA VERIFICAR PREMIUM
    
    function VerificarPremium($Time)
    {
        global $chatId, $username, $userId, $message_id, $My_ID, $Admin;
        $TiempoActual = time();
        if ($TiempoActual > $Time) {
            $file = array_values(array_unique(file('Users/Premium.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
            $out = [];
            foreach ($file as $line) {
                $user_value = explode("|", $line)[0];
                if ($user_value == $userId) {
                    $delete[] = $line;
                } else {
                    $out[] = $line;
                }
            }
            $fp = fopen('./Users/Premium.txt', "w+");
            foreach ($out as $line) {
                fwrite($fp, $line . PHP_EOL);
            }
            fclose($fp);
            $Rank = 'USER';
            $GLOBALS['Rank'] = $Rank;
        }
    }

#FUNCION PARA VERIFICAR PREMIUM DEL GRUPO
    
    function VerificarPremiumGrupo($Time)
    {
        global $chatId, $username, $userId, $message_id, $My_ID, $Admin;
        $TiempoActual = time();
        if ($TiempoActual > $Time) {
            $file = array_values(array_unique(file('Users/Premium.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
            $out = [];
            foreach ($file as $line) {
                $user_value = explode("|", $line)[0];
                if ($user_value == $chatId) {
                    $delete[] = $line;
                } else {
                    $out[] = $line;
                }
            }
            $fp = fopen('./Users/Premium.txt', "w+");
            foreach ($out as $line) {
                fwrite($fp, $line . PHP_EOL);
            }
            fclose($fp);
            $Rank_Group = 'USER';
            $GLOBALS['Rank_Group'] = $Rank_Group;
        }
    }

#FUNCION PARA AÑADIR CHAT-IDs(USUARIOS O GRUPOS)
    
    function AñadirChatID($data)
    {
        $file = fopen("Users/ChatIDs.txt", "a+");
        fwrite($file, $data . PHP_EOL);
        fclose($file);
    }

#FUNCION PARA SUBIR EL RANGO A PREMIUM(USUARIOS)
    
    function PremiumChatID($data)
    {
        $user = explode("|", $data)[0];
        $time = explode("|", $data)[1];
        $time = $time*24*3600;
        $time = time() + $time;
        $file = fopen("Users/Premium.txt", "a+");
        fwrite($file, $user.'|'.$time.'|'.time() . PHP_EOL);
        fclose($file);
#FUNCTION TO RAISE THE RANK TO ADMINISTRATOR (USERS)
    }

    
    function SetAdmin($data)
    {
        $file = fopen("Users/Admins.txt", "a+");
        fwrite($file, $data . PHP_EOL);
        fclose($file);
    }

#FUNCION PARA BANEAR USUARIOS
    
    function Ban($data)
    {
        $file = fopen("Users/Banned.txt", "a+");
        fwrite($file, $data . PHP_EOL);
        fclose($file);
    }

#FUNCION PARA DESBANEAR USUARIOS
    
    function Unban($data)
    {
        $file = array_values(array_unique(file('Users/Banned.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
        $out = [];
        foreach ($file as $line) {
            if ($line == $data) {
                $delete[] = $line;
            } else {
                $out[] = $line;
            }
        }
        $fp = fopen('./Users/Banned.txt', "w+");
        foreach ($out as $line) {
            fwrite($fp, $line . PHP_EOL);
        }
        fclose($fp);
    }

#FUNCION PARA VERIFICAR EL TIEMPO DE GRUPO
    
    function MyGroup($chatId)
    {
        global $Rank, $chatId, $username, $userId, $Rank_Group;

        if ($chatId == $userId) {
            $message = "Este comando es solo admitido para Grupos.";
            EnviarMensaje($chatId, $message, $message_id);
            exit();
        } elseif ($Rank_Group == "USER") {
            $tiempo_inicio =  "Vuelve Premium a tu Grupo y desbloquea nuevos comandos!\n";
            $tiempo_final = "";
            $texto3 = "🧨Si ocurre algun error habla a @KingProOficial";
        } else {
            $file = array_values(array_unique(file('Users/Premium.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));

            foreach ($file as $value) {
                $user_id = explode("|", $value)[0];
                $tiempo_inicio = explode("|", $value)[2];
                $tiempo_final = explode("|", $value)[1];
                if ($user_id == $chatId) {
                    $start_time = "📅Start date of your plan: ".date("dmY", $start_time)."\n"; 
                    $end_time = "🗓Expiration date: ".date("dmY", $end_time)."\n"; 
                    $texto3 = "🧨If an error occurs, talk to @KingProOficial"; 
                    break; 
                } 
            } 
        } 

        $message = "👮 Group ID: $chatId \n$start_time$end_time$text3"; 
        SendMessage($chatId, $message, $message_id); 
        exit(); 
    } 

#FUNCTION TO CHECK TIME 
    
    function MyAccount($userId) 
    { 
        global $Rank, $chatId,

        if ($Rank == 'OWNER' || $Rank == 'ADMIN') { 
            $start_time = "📅Your plan start date: Does not apply for ". $Rank."s\n"; 
            $final_time = "🗓Expiration date: Does not apply for ". $Rank."s\n"; 
            $texto3 = "🧨If an error occurs, talk to @KingProOficial"; 
        } elseif ($Rank == 'USER') { 
            $start_time = "Go Premium and unlock new commands!"; 
            $end_time = ""; 
            $texto3 = "\n🧨If any error occurs, talk to @KingProOficial"; 
        } else { 
            $file = array_values(array_unique(file('Users/Premium.txt',

                $user_id = explode("|", $value)[0];
                $tiempo_inicio = explode("|", $value)[2];
                $tiempo_final = explode("|", $value)[1];
                if ($user_id == $userId) {
                    $tiempo_inicio =  "📅Fecha de inicio de tu plan: ".date("d-m-Y", $tiempo_inicio)."\n";
                    $tiempo_final = "🗓Fecha de expiracion: ".date("d-m-Y", $tiempo_final)."\n";
                    $texto3 = "🧨Si ocurre algun error habla a @KingProOficial";
                    break;
                }
            }
        }

        $message = "👮User: @".$username."[".$userId."]{".$Rank."}\n$tiempo_inicio$tiempo_final$texto3";
        EnviarMensaje($chatId, $message, $message_id);
        exit();
    }

#FUNCION PARA BANEAR USUARIOS
    
    function Delete($data)
    {
        $file = array_values(array_unique(file('Users/ChatIDs.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
        $out = [];
        foreach ($file as $line) {
            if ($line == $data) {
                $delete[] = $line;
            } else {
                $out[] = $line;
            }
        }
        $fp = fopen('./Users/ChatIDs.txt', "w+");
        foreach ($out as $line) {
            fwrite($fp, $line . PHP_EOL);
        }
        fclose ( $ fp ); 
    } 

#FUNCTION TO VERIFY CHAT-IDs(USERS OR GROUPS) 
    
    function VerifyChatID($chatId) 
    { 
        global $chatId, $username, $userId, $message_id, $My_ID, $Admin; 

        $file = array_values(array_unique(file('Users/Banned.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES))); 
        foreach ($file as $key => $value) { 
            if ($value == $userId) { 
                $message = "!!️YOU HAVE BEEN BANNED BY THE ADMIN OF THIS BOT BECAUSE YOU DID SOMETHING WRONG!!️\nTo request access contact @KingProOficial "; 
                SendMessage($chatId, $message, $message_id); 
                exit ( ) ; 
            } 
        } }

        if ($chatId == $My_ID || $userId == $My_ID) {
            $Rank = 'OWNER';
            $GLOBALS['Rank'] = $Rank;
        } elseif ($Admin == true) {
            $Rank = 'ADMIN';
            $GLOBALS['Rank'] = $Rank;
        } elseif ($chatId == $userId) {
            $file = array_values(array_unique(file('Users/ChatIDs.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
            foreach ($file as $key => $value) {
                if ($value == $userId) {
                    $verificacion = 'Añadido';
                    break;
                }
            }
            if ($verificacion == 'Añadido') {
                $file = array_values(array_unique(file('Users/Premium.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
                foreach ($file as $key => $value) {
                    $value_id = explode("|", $value)[0];
                    $Time = explode("|", $value)[1];
                    if ($value_id == $userId) {
                        $Rank = 'PREMIUM';
                        $GLOBALS['Rank'] = $Rank;
                        VerificarPremium($Time);
                        break;
                    } else {
                        $Rank = 'USER';
                        $GLOBALS['Rank'] = $Rank;
                    }
                }
            } else { 
                $message = "‼️Hello, welcome to the best cheker bot ‼️ [@$username] [$userId]\n❌Sorry but to request access contact @KingProOficial\n✅Have a nice day!!!!"; 
                SendMessage($chatId, $message, $message_id); 
                exit(); 
            } 
        } elseif ($chatId != $userId) { 
            $file = array_values(array_unique(file('Users/ChatIDs.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES))); 
            foreach ($file as $key => $value) { 
                if ($value == $chatId) { 
                    $verification = 'Added'; 
                    break; 
                } else {
                    $verification = 'Not Added'; 
                } 
            } 
            if ($verification == 'Not Added') { 
                $file = array_values(unique_array(file('Users/ChatIDs.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES))); 
                foreach ($file as $key => $value) { 
                    if ($value == $userId) { 
                        $verification = 'Added'; 
                        break; 
                    } 
                } 
            } 
            if ($verification == 'Added') { 
                $file = array_values(unique_array(file('Users/Premium.txt',
                foreach ($file as $key => $value) {
                    $value_id = explode("|", $value)[0];
                    $Time = explode("|", $value)[1];
                    if ($value_id == $chatId) {
                        $Rank_Group = 'PREMIUM';
                        $GLOBALS['Rank_Group'] = $Rank_Group;
                        VerificarPremiumGrupo($Time);
                        break;
                    } else {
                        $Rank_Group = 'USER';
                        $GLOBALS['Rank_Group'] = $Rank_Group;
                    }
                }
                $file = array_values(array_unique(file('Users/Premium.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
                foreach ($file as $key => $value) {
                    $value_id = explode("|", $value)[0];
                    $Time = explode("|", $value)[1];
                    if ($value_id == $userId) {
                        $Rank = 'PREMIUM';
                        $GLOBALS['Rank'] = $Rank;
                        VerificarPremium($Time);
                        break;
                    } else {
                        $Rank = 'USER';
                        $GLOBALS['Rank'] = $Rank;
                    }
                }
            } else { 
                $message = "!!️Hello welcome to the best bot cheker !!️ [@$username] [$userId]\n❌Sorry but to request access contact @KingProOfficial\n✅Have a nice day!!!!"; 
                SendMessage($chatId, $message, $message_id); 
                exit ( ) ; 
            } 
        } 
    } 

#FUNCTION TO VERIFY PREMIUM 
    
    function Premium() 
    { 
        global $chatId, $username, $userId, $message_id, $My_ID, $Admin, $Rank, $Rank_Group; 
        if ($userId == $My_ID || $chatId == $My_ID || $Admin == true || $Rank_Group == 'PREMIUM' || $Rank == 'PREMIUM') { 
        } else {
            $message = "‼️Hello, you need to be a Premium User or Group to use this command ‼️ [@$username] [$userId]\n❌Sorry but to request access contact @KingProOficial\n✅Have a nice day!! !!"; 
            SendMessage($chatId, $message, $message_id); 
            exit(); 
        } 
    } 

#FUNCTION TO SUBSTRATE CARD WITH ANY COMMAND 
    
    function GetCard($message) 
    { 
        $clean = explode(" ", $message)[1]; 
        return $clean; 
    } 

#FUNCTION TO QUERY API 
    
    function QueryAPI($File, $Card) 
    { 
        $server = $_SERVER['SERVER_NAME']; 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://'.$server.'/bot@KingProOficial/Apis/'.$Archivo.'?lista='.$Card);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, []);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $Resultado = curl_exec($ch);
        $GLOBALS['Resultado'] = $Resultado;
    }

#FUNCTION TO QUERY API 
    
    function Response($Gateway, $Result, $Rank) 
    { 
        global $chatId, $username, $userId, $message_id, $File, $Rank; 

        if ($Gateway == 'CC Generator' || $File == 'CardGenerator.php') { 
            $Result = str_replace("-", "\n", $Result); 
            $Result = "✅ NAMSO GENERATOR:\n".$Result; 
            SendMessage($chatId, $Result, $message_id); 
        } else { 
            preg_match_all('/\[(.*?)\] => (.*?)\./', $Result, $output_array); 

            $x = 0; 

            do { 
                $array_new[''.$output_array[1][$x].''] = $output_array[2][$x];
            } while (!empty($output_array[0][$x])); 

            $Card = $array_new['Card']; 
            $Status = $array_new['Status']; 
            $Bin = $array_new['Bin']; 
            $Scheme = $array_new['Scheme']; 
            $Type = $array_new['Type']; 
            $Brand = $array_new['Brand']; 
            $Country = $array_new['Country']; 
            $Bank = $array_new['Bank']; 
            $Flag = $array_new['Flag']; 
            $Currency = $array_new['Currency']; 

            if ($Gateway == 'BIN Lookup' || $File == 'BinLookup.php') {
                $message = "⚜️Bin Válido\n💳Bin: $Bin\n🧨Info: $Scheme - $Tipo - $Brand\n🏦Bank: $Banco\n🌐Country: $Pais $Bandera\n💸Currency: $Currency\n💣Checked By: @$username { $Rank }\n🤴Made by: @KingProOficial";
                EnviarMensaje($chatId, $message, $message_id);
            } else {
                $message = "💳Card -›› $Card\n⚡️Status -›› $Status\n‼️Gateway: $Gateway\n➖➖➖➖➖➖➖➖➖➖\n〰️〰️Detalles del bin〰️〰️\n🧨Bin -›› $Bin - $Scheme  - $Tipo - $Brand\n🏦Bank -›› $Banco\n💣Country -›› $Pais $Bandera - 💲$Currency\n〰️〰️〰️‹‹Info››〰️〰️〰️\n☑️Proxy -›› ???\n👁‍🗨Checked By -›› @$username { $Rank } \n🤴Bot By: @KingProOficial";
                EnviarMensaje($chatId, $message, $message_id);
            }
        }
    }
