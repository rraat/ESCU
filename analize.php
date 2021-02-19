<?php
class Communication{
    private const KEY =
        "Ei2HNryt8ysSdRRI54XNQHBEbOIRqNjQgYxsTmuW3srSVRVFyLh8mwvhBLPFQph3".
        "ecDMLnDtjDUdrUwt7oTsJuYl72hXESNiD6jFIQCtQN1unsmn3JXjeYwGJ55pqTkV".
        "yN2OOm3vekF6G1LM4t3kiiG4lGwbxG4CG1s5Sli7gcINFBOLXQnPpsQNWDmPbOm7".
        "4mE7eyR3L7tk8tUhI17FLKm11hrrd1ck74bMw3VYSK3X5RrDgXelewMU6o1tJ3iX";

    private const MSG_TYPE=[
        0=>"probe",
        1=>"query",
        2=>"response",
        3 =>"push",
        4 =>"push_response"
    ];
    private const ERROR_MSG =[
            0=>"None",
            5=>"g_err_userChanged2", //sys_user_pwdIsWrong
            6=>"g_err_ipInvalid",
            7=>"g_err_userChanged",
            8=>"g_err_tokenError",
            9=>"g_err_maskInvalid",
            10=>"g_err_gatewayInvalid",
            11=>"sys_upgrade_ipConflict", //system upgrade error.
            7400=>"sw_trunk_port_used_by_trunk",
            7401=>"sw_trunk_vlanErrorForSG108E",
            7402=>"sw_trunk_port_in_mirror",
            7403=>"sw_trunk_rateErrorForSG108E",
            7404=>"sw_trunk_stormErrorForSG108E",
            7405=>"sw_trunk_qosErrorForSG108E",
            7406=>"sw_trunk_portSpeedForSG108E",
            7407=>"sw_trunk_portDuplexForSG108E",
            7408=>"sw_trunk_rtk_not_exist",
            7409=>"sw_trunk_rkk_out_of_range",
            7410=>"sw_trunk_portNegoForSG108E",
            7411=>"sw_trunk_port_not_member_port",
            7412=>"sw_trunk_less_than_2_ports",
            7413=>"sw_trunk_more_than_4_port",
            7414=>"sw_trunk_port_in_trunk",
            7415=>"sw_trunk_portNumberForSG108E",
            7416=>"sw_trunk_port_num_too_high",
            7417=>"sw_trunk_portFlowForSG108E",
            7418=>"sw_trunk_portStatusForSG108E",
            7419=>"sw_trunk_mtuVlanConflict",
            7420=>"sw_trunk_error_config",
            7503=>"vlan_err_notExist",
            7505=>"vlan_dot1q_vlanFull",
            7508=>"vlan_err_notExist",
            7516=>'VLAN is not existed, please create it first.',
            7517=>'You could not modify Management VLAN when MTU VLAN is enabled.',
            7518=>'At least one port pvid should be Management VLAN.',
            7900=>'sw_port_spdFcSet',
            7901=>'sw_port_spdLagSet',
            7902=>'sw_port_spdSfpSet',
            8001=>'poe_recovery_invalid_ip',
            8101=>'poe_extend_change_spdDplxFC',
            0xfffffffd => "sw_trunk_speedError",
            0xfffffffe => "sw_trunk_flowctrlError", //dis_saveConfigFail  int32 -2
            0xffffffff => "sw_trunk_vlanError",
        ];

    private const CABLE_TEST= [
        0=>"NO_CABLE",
        1=>"NORMAL",
        2=>"OPEN",
        3=>"SHORT",
        4=>"OPEN_SHORT",
        5=>"CROSS_CABLE"
    ];

    private const LINK_SPEED = [
        0=>'LINK_DOWN',
        1=>'AUTO',
        2=>'MH10',
        3=>'MF10',
        4=>'MH100',
        5=>'MF100',
        6=>'MF1000'
    ];

    private const CABLE_STATUS=[
        0=>'NO_CABLE',
        1=>'NORMAL',
        2=>'OPEN',
        3=>'SHORT',
        4=>'OPEN_SHORT',
        5=>'CROSS_CABLE'
    ];

    private const QOS_MODE = [
        0=>"Port Based",
        1=>"802.1P Based",
        2=>"DSCP/802.1P Based "
    ];


    private static $tlvInfo = [

             0x0001 => ["productModel","string"],
             0x0002 => ["deviceDescription","string"],
             0x0003 => ["macAddress" ,"mac"],
             0x0004 => ["switchIpAddress","ip"],
             0x0005 => ["mask" ,"ip"],
             0x0006 => ["gateway","ip"],
             0x0007 => ["firmwareVer","string"],
             0x0008 => ["hardwareVer","string"],
             0x0009 => ["dhcpEnabled" ,"bool"],
             0x000A => ["portcount","C1"],
             0x000C => ["ledStatus","bool"],
             0x000D => ["autoSave","bool"],
             0x000E => ["isFactory","bool"],
             0x000F => ["switchFlashType","uint16"],

             0x0200 => ["username","string"],
             0x0201 => ["new_username","string"],
             0x0202 => ["password","string"],
             0x0203 => ["new_password","string"],

             0x0300 => ["read_config file","hex"],
             0x0301 => ["write_config file","hex"],
             0x0305 => ["reboot","bool"],

             0x0500 => ["factoryReset","*hex"],

             0x0600 => ["upgradeFirmwareMode","nop"],

             0x0901 => ["new_session","nop"],

             0x1000 => ["port_config","C1portnumber/C1enabled/C1LagNo/C1configuredSpeed/C1actualSpeed/C1configuredFlowControl/C1actualFlowControl"],

             0x1100 => ["igmpSnooping","bool"],
             0x1101 => ["igmpPaths","igmppath"],
             0x1102 => ["reportMessageSuppression","bool"],

             0x1200 => ["lag2Members","groupmembers"],

             0x2000 => ["mtuStatus","C1enabled/C1uplinkport"],

             0x2100 => ["portBasedVlan","bool"],
             0x2101 => ["portBasedVlanMembers","groupmembers"],
             0x2102 => ["portBasedVlanPortcount","uint8"],

             0x2200 => ["802.1q","bool"],
             0x2201 => ["802.1qvlans","vlanconfig"],
             0x2202 => ["PortDefaultId","C1Port/n1vlanid"],
             0x2203 => ["maxVlanCount","uint8"],

             0x3000 => ["qosMode","qosmode"],
             0x3001 => ["qosPortPriority","*C1Port/C1Priority"],

             0x3100 => ["PortIngressBandwithSettings","C1Port/C1enabled/N1speed"], //n1Limit/
             0x3101 => ["PortEgressdBandwithSettings","C1Port/C1enabled/N1speed"], //n1Limit/

             0x3200 => ["PortStormControlSettings","C1Port/C1enabled/C1UlFrame/C1Multicast/C1Broadcast/N1speed"],

             0x4000 => ["PortStatistics","C1portno/C1enabled/C1speed/N1txGoodPkt/N1txBadPkt/N1rxGoodPkt/N1rxBadPkt"],

             0x4100 => ["PortMirror","mirrorinfo"],

             0x4200 => ["CableTest","C1portnumber1/C1cableStatus/N1faultDistance"],

             0x4300 => ["LoopPrevention","bool"],

             0xffff=>["EOF","nop"]
    ];


    private $key;
    private $state;
    private $state_x;
    private $state_y;

    private $address;
    private $port;
    private $packetSize;

    private $sockets=[];
    private $context;


    public function __construct($address="0.0.0.0",$ports=[29808,29809,62576],$key=self::KEY,$packetSize=1600){
        $this->address = $address;
        $this->ports = $ports;
        $this->key = $key;
        $this->packetSize = $packetSize;

    }


    private function getSetFlags($value,$bitcount=32){
        $flags = [];
        for ($i=1; $i<=$bitcount; $i++){
            if((($value>>($i-1)) & 1) == 1){
                $flags[] = $i;
            }
        }
        return $flags;
    }

    private function escape($string,$force=false){
        return implode("",array_map(function($char)use($force){
            return ($force || $char<" " || $char> "~") ? "\\x".bin2hex($char) : $char;
        },str_split($string)));
    }

    private function unpack_tlv($type,$value){
        if(!isset(self::$tlvInfo[$type])){
            echo "\n\x1b[1;31m";
            return  ["0x".dechex($type), strlen($value)." ".implode("",unpack("H*",$value))." {$this->escape($value)}"];

        }
        list($name,$basetype) = self::$tlvInfo[$type];
        if($basetype[0] == "*"){
            echo "\x1b[1;31m";
            $basetype = substr($basetype, 1);
        }

        if(strlen($value) == 0) return [$name,null];

        switch ($basetype) {
            case "vlanconfig":
                $info = unpack("n1vlanid/N1members/N1untagged/a*name",$value);
                $info["members"] = $this->getSetFlags($info["members"],32);
                $info["untagged"] = $this->getSetFlags($info["untagged"],32);
                return [$name,$info];
            case "groupmembers":
                $info = unpack("C1group/N1selected",$value);
                $info["selected"] = $this->getSetFlags($info["selected"],32);
                return [$name,$info];
            case 'mirrorinfo':
                $info = unpack("C1enable/C1mirrorport/N1incomming/N1outgoing",$value);
                $info["incomming"] = $this->getSetFlags($info["incomming"],32);
                $info["outgoing"] = $this->getSetFlags($info["outgoing"],32);
                return [$name,$info];
            case 'igmppath':
                $info = unpack("N1ip/n1vlan/N1ports",$value);
                $info['ip'] = long2ip($info['ip']);
                $info['ports'] = $this->getSetFlags($info["ports"],32);
                return [$name,$info];
            case "qosmode":
                $qosMode = ord($value[0]);
                return [$name,isset(self::QOS_MODE[$qosMode]) ? self::QOS_MODE[$qosMode] : $qosMode];

            case "bin":     return [$name,$value];
            case "hex":     return [$name,implode("",unpack("H*",$value))];
            case "nop":     return [$name,null];
            case "string":  return [$name,unpack("a*",$value)[1]];
            case "ip":      return [$name,implode(".",unpack("C4",$value))];
            case "mac":     return [$name,implode(":",str_split(unpack("H12",$value)[1],2))];
            case "bool":    return [$name,(!!unpack("C1",$value)[1]?"y":"n")];
            case "uint8":   return [$name,unpack("C1",$value)[1]];
            case "uint16":  return [$name,unpack("N1",$value)[1]];
            default:        return [$name,unpack($basetype,$value)];
        }
        return [null,null];
    }

    private function unpack_header($value){
        $header = unpack("C1version/C1type/H12switch_mac/H12client_mac/n1sequence/N1error_code/n1length/n1fragment/n1reserved/n1token/N1crc",$value);

        $header["error_msg"] = isset(self::ERROR_MSG[$header["error_code"]]) ? self::ERROR_MSG[$header["error_code"]] : "unknown error {$header["error_code"]}";
        $header["type"] = self::MSG_TYPE[$header["type"]];
        $header["switch_mac"] = implode(":",str_split($header["switch_mac"],2));
        $header["client_mac"] = implode(":",str_split($header["client_mac"],2));

        return $header;

    }

    public function __destruct(){
        $this->close();
    }

    public function open(){

        if($this->context=== null || !is_resource($this->context)){
            $this->context = stream_context_create([
                "socket"=>[
                    "so_broadcast"=>"255.255.255.255"
                ]
            ]);
        }
        foreach($this->ports as $port){
            if(!isset($this->sockets[$port]) || !is_resource($this->sockets[$port])){
                $errno=0;$errstr="";
                if(($this->sockets[$port] = stream_socket_server("udp://{$this->address}:{$port}",$errno,$errstr,STREAM_SERVER_BIND,$this->context))===FALSE){
                    throw new \Exception($errstr,$errno);
                }
                echo "listening on:".stream_socket_get_name($this->sockets[$port],false)."\n";
            }
        }
    }

    public function close(){
        foreach($this->ports as $port){
            if(is_resource($this->sockets[$port])){
                stream_socket_shutdown($this->sockets[$port],STREAM_SHUT_RDWR );
                fclose($this->sockets[$port]);
                unset($this->sockets[$port]);
            }
        }
    }

    private function rc4_reset(){
        $this->state =  range(0, 255);
        $this->state_x = 1;
        $this->state_y = 0;
        for($len = strlen($this->key), $j = $i = 0; $i < 256; $i++ ){
            $j = (ord($this->key[$i % $len]) + $this->state [$i] + $j ) % 256;
            //flip state values
            list($this->state [$i],$this->state [$j]) =array($this->state [$j],$this->state [$i]);
        }
    }

    private function rc4_crypt($data) {
        for($l=0;$l<strlen($data);$l++){
            $x = ($this->state_x) % 256;
            $y = ($this->state[$x] + $this->state_y) % 256;
            //flip
            list($this->state[$x],$this->state[$y]) = array($this->state[$y],$this->state[$x]);

            // php can xor chars                        but we can not add 2 chars
            $data[$l] = $data[$l] ^ chr($this->state[($this->state[$x] + $this->state[$y]) % 256]);
            $this->state_x++;
            $this->state_y = $y;
        }
        return $data;
    }

    private function cut_str($string,array $after = []){
        $prev = 0;
        $strings = [];
        foreach($after as $offset){
            $strings[] = substr($string,$prev,$offset-$prev);
            $prev+=$offset;
        }
        $strings[] = substr($string,$prev); //remainder
        return $strings;
    }

    public function select(callable $on_msg=null,callable $on_idle=null,$timeout=1){
        static $direction = [29808 => "mgt->switch",29809 => "switch->mgt",62576 => "mgt->switch (v2)"];
        $read = $this->sockets;
        $write=[];
        $except=[];
        $result = stream_select($read, $write, $except, $timeout);
        if($result === false){
            return false;
        }elseif($result === 0 && isset($on_idle)){
            $on_idle($this);
        }elseif(count($read)>0){
            foreach($read as $incomming){
                $port = array_search($incomming, $this->sockets,true);
                $this->rc4_reset();
                $buffer = fread($incomming, $this->packetSize);
                do{
                    if(strlen($buffer) < 32){
                        echo "dataloss buffer(".strlen($buffer).") < 32)\n";
                        return;
                    }
                    list($headerBytes,$buffer) = $this->cut_str($buffer,[32]);
                    $msg = [
                        "header"=>$this->unpack_header($this->rc4_crypt($headerBytes)),
                        "port"=>$port,
                        "direction"=>isset($direction[$port]) ? $direction[$port] : "unknown",
                        "values" => []
                    ];


                    list($payloadBytes,$buffer) = $this->cut_str($buffer,[$msg["header"]["length"]-32]);
                    if(strlen($payloadBytes) < $msg["header"]["length"]-32){
                        echo "dataloss payload(".(strlen($payloadBytes)+32).") < header['length']({$msg["header"]["length"]})\n";
                        return;
                    }
                    $payload = $this->rc4_crypt($payloadBytes);
                    $this->rc4_reset();

                    while($payload!=""){
                        list($ident,$payload) = $this->cut_str($payload,[4]);
                        $tlvHeader = unpack("n1type/n1length",$ident);
                        list($content,$payload) = $this->cut_str($payload,[$tlvHeader["length"]]);
                        list($name,$parsed) = $this->unpack_tlv($tlvHeader["type"],$content);
                        if($name == "EOF"){
                            if( $payload != ""){
                                echo "dataloss payload contains an excess of ".strlen($payload)." bytes\n";
                            }
                        }elseif(!isset($msg["values"][$name])){
                            $msg["values"][$name] =  [$parsed];
                        }else{
                            $msg["values"][$name][] = $parsed;
                        }
                    }
                    $values = $msg["values"];
                    foreach ($values as $key => $value) {
                        if(count($value) == 1) {
                            $msg["values"][$key] = $value[0];
                        }
                    }
                    $on_msg($msg);

                }while($buffer);
            }

        }
        return true;
    }

}

$ip =current( (array_filter(dns_get_record ($hostname=gethostname()),function($spec){
    return $spec["type"]=="A";
})?:[["ip"=>gethostbyname($hostname)]]))["ip"];

$r = new Communication($ip);
$r->open();
$i=0;
while($r->select(
    function($msg)use($i){
        echo"-------------------------------------------------------------------------------------------\n";
        print_r($msg);
        echo"-------------------------------------------------------------------------------------------\x1b[39;49m\n";
    },
    function()use($i){

    }
    )){
        $i++;
 }
