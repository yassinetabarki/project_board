<?php
function gravatar_email($email){
$email=md5($email);
return "https://gravatar.com/avatar/{{$email}}?s=50&";
}