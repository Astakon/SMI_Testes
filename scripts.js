/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 

function EmailValidator(pass) {
  filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,3})$/;
  
  //alert(pass);
  if(!filter.test(pass)){
      document.getElementById('email_response').innerHTML = 'Email Format Invalid';
      document.getElementById('email_response').style.color = 'red';
      document.getElementById('register').disabled = true;
      return;
  }  
  else{
      document.getElementById('email_response').innerHTML = 'Email Format Valid and Available';
        document.getElementById('email_response').style.color = 'green';
        document.getElementById('register').disabled = false;
  }
}
function UsernameValidator(pass) {
  var filterUpdate = /^[a-zA-Z0-9_.-]{6,}$/;
  
  //alert(pass);
  if(!filterUpdate.test(pass)){
      document.getElementById('uname_response').innerHTML = 'Username Format Invalid';
      document.getElementById('uname_response').style.color = 'red';
      document.getElementById('register').disabled = true;
      return;
  }  
  else{
      document.getElementById('uname_response').innerHTML = 'Username Format Valid and Available';
        document.getElementById('uname_response').style.color = 'green';
        document.getElementById('register').disabled = false;
  }
}

function UsernameValidator2(pass) {
  var filterUpdate = /^[a-zA-Z0-9_.-]{6,}$/;
  
  //alert(pass);
  if(!filterUpdate.test(pass)){
      document.getElementById('uname_response').innerHTML = 'Username Format Invalid';
      document.getElementById('uname_response').style.color = 'red';
      document.getElementById('saveName').disabled = true;
      return;
  }  
  else{
      document.getElementById('uname_response').innerHTML = 'Username Format Valid and Available';
        document.getElementById('uname_response').style.color = 'green';
        document.getElementById('saveName').disabled = false;
  }
}
function PasswordValidator(pass) {
  var filterUpdate = /^[a-zA-Z0-9_.-]{6,}$/;
  if(pass.length >0){
  //alert(pass);
  if(!filterUpdate.test(pass)){
      document.getElementById('passwordReg').innerHTML = 'Password Format Invalid';
      document.getElementById('passwordReg').style.color = 'red';
      document.getElementById('register').disabled = true;
      return;
  }  
  else{
      document.getElementById('passwordReg').innerHTML = 'Password Format Valid';
        document.getElementById('passwordReg').style.color = 'green';
        document.getElementById('register').disabled = false;
  }
  }
  else{
      document.getElementById('passwordReg').innerHTML = '';
        document.getElementById('register').disabled = false;
  }
}

function PasswordValidator2(pass) {
  var filterUpdate = /^[a-zA-Z0-9_.-]{6,}$/;
  if(pass.length >0){
  //alert(pass);
  if(!filterUpdate.test(pass)){
      document.getElementById('passwordReg').innerHTML = 'Password Format Invalid';
      document.getElementById('passwordReg').style.color = 'red';
      document.getElementById('savePw').disabled = true;
      return;
  }  
  else{
      document.getElementById('passwordReg').innerHTML = 'Password Format Valid';
        document.getElementById('passwordReg').style.color = 'green';
        document.getElementById('savePw').disabled = false;
  }
  }
  else{
      document.getElementById('passwordReg').innerHTML = '';
        document.getElementById('savePw').disabled = false;
  }
}