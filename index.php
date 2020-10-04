<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-app.js"></script>



<!--include firebase database-->
<script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-database.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-analytics.js"></script>

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyBcXcQBMcR2W--DPl6-Gcqdw8hxlj4_Gck",
    authDomain: "my-test-project-7a2b5.firebaseapp.com",
    databaseURL: "https://my-test-project-7a2b5.firebaseio.com",
    projectId: "my-test-project-7a2b5",
    storageBucket: "my-test-project-7a2b5.appspot.com",
    messagingSenderId: "667329305981",
    appId: "1:667329305981:web:b0c0119012397b1c4e0014",
    measurementId: "G-1HP65EXXPL"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();

  var myName = prompt("Enter your name");
  function sendMessage()
  {
    //get message
    var message=document.getElementById("messaage").value;
    //save in database
    firebase.database().ref("messages").push().set({"sender":myName,"message":message}); 
    return false;
  }

  //listen for incoming messages
  firebase.database().ref("messages").on("child_added",function (snapshot){
    var html="";
    //give each message a unique ID
    html += "<li id='message-" +snapshot.key + "'>";
    //show delete button if message is sent by me
    if (snapshot.val().sender == myName ){
      html += "<button data-id='" + snapshot.key + "' onclick='deleteMessage(this);'>"
      ;
      html += "Delete";
      html += "</button>";
    }
      html += snapshot.val().sender + ":" + snapshot.val().message;
    html += "</li>";

    document.getElementById("messages").innerHTML += html;
  });
  function deleteMessage(self)
  {
    //get message ID
    var messageId = self.getAttribute("data-id");

    //delete message
    firebase.database().ref("messages").child(messageId).remove();

  }
  //attach listener for delete message
  firebase.database().ref("messages").on("child_removed",function(snapshot){
    //remove message node
    document.getElementById("message-" + snapshot.key).innerHTML = "This message has been removed";
  })
  </script>
<!--create a form to send message-->
<form onsubmit="return sendMessage();">
<input id="messaage" placeholder="Enter message" autocomplete="off">
<input type="submit">
</form>
<!--create a list-->
<ul id="messages"></ul>