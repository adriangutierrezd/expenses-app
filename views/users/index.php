<?php 
require_once 'helpers/Utils.php';
require_once 'helpers/form.php';
?>


<!-- CONTENT -->
<div>
<?= showFeeback(); ?>

<h1 class="h1">Cuenta</h1>


<!-- LOG OUT -->
<div class="w-full flex items-center justify-end my-2">
  <a href="<?=base_url.'user/logout'?>" class="inline-block rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Cerrar sesión</a>
</div>

<!-- UPDATE USER -->
<div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl w-full border border-gray-100 my-8">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
            <!-- Heroicon name: outline/exclamation -->
            <i class="bi bi-person text-blue-700"></i>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-grow">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Actualizar datos</h3>
            <div class="mt-2">
            <form action="<?=base_url.'user/update'?>" method="post">
            <div class="form-group">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= $user->getName(); ?>">
                <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['name'])){
                  echo showErrorForm($_SESSION['errors'], 'name');
                } ?>
            </div>
            <div class="form-group">
                <label for="username" class="form-label">Nombre de usuario:</label>
                <input type="text" name="username" id="username" class="form-control" value="<?= $user->getUsername(); ?>">
                <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['username'])){
                  echo showErrorForm($_SESSION['errors'], 'username');
                } ?>
            </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Actualizar</button>
        </form>
    </div>
</div>

<!-- UPDATE PASSWORD -->
<div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl w-full border border-gray-100 my-8">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
            <!-- Heroicon name: outline/exclamation -->
            <i class="bi bi-lock text-blue-700"></i>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-grow">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Actualizar contraseña</h3>
            <div class="mt-2">
            <form action="<?=base_url.'user/updatePassword'?>" method="post">
            <div class="form-group">
                <label for="actualPassword" class="form-label">Contraseña actual:</label>
                <input type="password" name="actualPassword" id="actualPassword" class="form-control">
                <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['actualPassword'])){
                  echo showErrorForm($_SESSION['errors'], 'actualPassword');
                } ?>
            </div>
            <div class="form-group">
                <label for="newPassword" class="form-label">Nueva contraseña:</label>
                <input type="password" name="newPassword" id="newPassword" class="form-control">
                <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['newPassword'])){
                  echo showErrorForm($_SESSION['errors'], 'newPassword');
                } ?>
            </div>

            <div class="form-group">
                <label for="newPasswordRepeat" class="form-label">Repetir nueva contraseña:</label>
                <input type="password" name="newPasswordRepeat" id="newPasswordRepeat" class="form-control">
                <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['newPasswordRepeat'])){
                  echo showErrorForm($_SESSION['errors'], 'newPasswordRepeat');
                } ?>
            </div>

              
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Actualizar contraseña</button>
        </form>
    </div>
</div>



<!-- DELETE ACCOUNT -->
<div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl w-full border border-gray-100 my-8">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
            <!-- Heroicon name: outline/exclamation -->
            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Eliminar cuenta</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">¿Seguro que quieres eliminar tu cuenta? Esta acción no se puede deshacer y no podrás recuperar tu información.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
      <form action="<?=base_url.'user/delete'?>" method="post">
        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Eliminar</button>
        </form>
    </div>
</div>


<?php deleteFeedback(); deleteErrors(); ?>