<?php 
require_once 'helpers/Utils.php';
require_once 'helpers/form.php';
?>


<!-- CONTENT -->
<div class="max-w-7xl mx-auto my-6 px-4 h-screen">
<?= showFeeback(); ?>


<div class="flex items-center justify-center flex-col h-full">

<!-- TOGGLE -->
  <div class="flex justify-center items-center">
    <span class="mr-3 font-semibold">Iniciar sesión</span>
    <div id="toggle">
      <i class="indicator"></i>
    </div>
    <span class="ml-3 font-semibold">Registrarse</span>
  </div>

  <!-- LOGGIN USER -->
  <div id="loggin" class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl w-full border-2 border-gray-100 my-8">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
              <!-- Heroicon name: outline/exclamation -->
              <i class="bi bi-person text-blue-700"></i>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-grow">
              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Iniciar sesión</h3>
              <div class="mt-2">
              <form action="<?=base_url.'user/log'?>" method="post">
              <div class="form-group">
                  <label for="usernameRegister" class="form-label">Nombre de usuario:</label>
                  <input type="text" name="usernameRegister" id="usernameRegister" class="form-control">
                  <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['usernameRegister'])){
                    echo showErrorForm($_SESSION['errors'], 'usernameRegister');
                  } ?>
              </div>
              <div class="form-group">
                  <label for="passwordRegister" class="form-label">Contraseña:</label>
                  <input type="password" name="passwordRegister" id="passwordRegister" class="form-control">
                  <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['passwordRegister'])){
                    echo showErrorForm($_SESSION['errors'], 'passwordRegister');
                  } ?>
              </div>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Iniciar sesión</button>
          </form>
      </div>
  </div>


  <!-- REGISTER USER -->
  <div id="register" class="hidden relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl w-full border-2 border-gray-100 my-8">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
              <!-- Heroicon name: outline/exclamation -->
              <i class="bi bi-person text-blue-700"></i>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-grow">
              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Registrarse</h3>
              <div class="mt-2">
              <form action="<?=base_url.'user/save'?>" method="post">
              <div class="form-group">
                  <label for="name" class="form-label">Nombre:</label>
                  <input type="text" name="name" id="name" class="form-control">
                  <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['name'])){
                    echo showErrorForm($_SESSION['errors'], 'name');
                  } ?>
              </div>
              <div class="form-group">
                  <label for="username" class="form-label">Nombre de usuario:</label>
                  <input type="text" name="username" id="username" class="form-control">
                  <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['username'])){
                    echo showErrorForm($_SESSION['errors'], 'username');
                  } ?>
              </div>
              <div class="form-group">
                  <label for="password" class="form-label">Contraseña:</label>
                  <input type="password" name="password" id="password" class="form-control">
                  <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['password'])){
                    echo showErrorForm($_SESSION['errors'], 'password');
                  } ?>
              </div>
              <div class="form-group">
                  <label for="passwordRepeat" class="form-label">Repetir contraseña:</label>
                  <input type="password" name="passwordRepeat" id="passwordRepeat" class="form-control">
                  <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['passwordRepeat'])){
                    echo showErrorForm($_SESSION['errors'], 'passwordRepeat');
                  } ?>
              </div>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Crear cuenta</button>
          </form>
      </div>
  </div>

</div>

<?php deleteFeedback(); deleteErrors(); ?>

</div>
</div>

<script>
  var toggle = document.getElementById('toggle');
  toggle.addEventListener('click', () => {
    toggle.classList.toggle('active');
    document.getElementById('loggin').classList.toggle('hidden');
    document.getElementById('register').classList.toggle('hidden');
  });
</script>