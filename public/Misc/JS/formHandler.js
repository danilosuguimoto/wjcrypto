$(function () {
  handleForm();
});

function handleForm() {
  let password = $('#password').val();
  let confirmPassword = $('#confirm-password').val();

  $('#createacc').submit(function (event) {
    if(password != confirmPassword) {
      event.preventDefault();
      alert('Os campos de senha devem conter o mesmo valor.');
    }
  });
}