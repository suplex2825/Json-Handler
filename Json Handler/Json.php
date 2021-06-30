<?php 
  error_reporting (E_ALL ^ E_NOTICE);


	class Server {
  function handle($payload) {

    $arr = json_decode($payload, true);


    return $arr;
  }

  // TODO: Implement the rest of the class
}

class ChatRoom   {
  public function getMessageCount($data) {
    // TODO: Implement this function.
    $messages = array();

   $length = count($data);

   for($i = 0; $i < $length; $i++) {
       if(in_array($data[$i]["params"]["message"], $data[$i]["params"])) {
          $messages[] = $data[$i]["params"];
        }
       
   }  


    return count($messages);


  }

  // TODO: Implement the rest of the class
}


class MemberSystem {
  public function getAgeByEmail($email, $data) {
    // TODO: Implement this function.
    $results = array();

    $length = count($data);
    
     for($i = 0; $i < $length; $i++) {
   
       if($data[$i]["params"]["email"] === $email) {
        $results[] = $data[$i];
       }
        
       
      }


        return $results[0]["params"]["age"];
     
    

  }



 function removeMember($array, $key, $value){
     foreach($array as $subKey => $subArray){
          if($subArray[$key] == $value){
               unset($array[$subKey]);
          }
     }

     return $array;
}

  // TODO: Implement the rest of the class
}

// Initiate the server
$server = new Server();

// Initiate services
$chatroom = new ChatRoom();
$memberSystem = new MemberSystem();


// TODO: Register the services above to the server object

/************************************
 * !! DO NOT EDIT CONTENT BELOW !!  *
 ************************************/

// Sending 4 requests at once
// Don't need to support the last request, just ignore it
$arr = $server->handle('
[ 
  {
    "method": "chatroom.new_message", 
    "params": { "message": "Foo" }
  },
  {
    "method": "chatroom.new_message", 
    "params": { "message": "Bar" }
  },
  {
    "method": "member.new_member", 
    "params": { "email": "jason@example.com", "age": 12 }
  },
  {
    "method": "member.remove_member", 
    "params": { "email": "tony@example.com" }
  },

  {
    "method": "member.new_member", 
    "params": { "email": "lali@example.com", "age": 13 }
  }, 

   {
    "method": "chatroom.new_message", 
    "params": { "message": "Yes" }
  }, 

   {
    "method": "member.new_member", 
    "params": { "email": "Chili@example.com", "age": 20 }
  }
]
');


echo sprintf(
  "Chat room message count: %s (Expected: 2)\n",
   $chatroom->getMessageCount($arr)// Return 2
);

echo "<br>";

echo sprintf(
  "lali's age: %s (Expected: 20)\n",
  $memberSystem->getAgeByEmail("lali@example.com", $arr)// Return 12
); 


echo "<h4>Removed member array:</h4>";
echo "<pre>";
print_r($memberSystem->removeMember($arr, "method", "member.remove_member"));
echo "</pre>";


?>