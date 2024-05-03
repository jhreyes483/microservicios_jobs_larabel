<template>
    <div class="">
        <nav class="navbar navbar-expand-lg navbar-light bg-light ">
            <div class="container-fluid navbar">
                <div>
                    <img class="avatar_mask" alt="Alegra" src="https://th.bing.com/th/id/OIP.qMRX44T-Qs-bBhYUIDnj-QAAAA?rs=1&pid=ImgDetMain">
                </div>
                <b>Alegra</b> &nbsp; Reto restaurante
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    </ul>
                    <ul class="navbar-nav navbar-right mr-auto">
                        <li class="nav-item">
                            <router-link active-class="active" to="/login" class="nav-link">Login</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link active-class="active" to="/home" class="nav-link">inicio</router-link>
                        </li>  
                        <li class="nav-item">
                            <router-link active-class="active" to="/orders" class="nav-link">Ordenes</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link active-class="active" to="/recipe" class="nav-link">Recetas</router-link>
                        </li>

                        <li class="nav-item">
                            <router-link active-class="active" to="/history_movoments" class="nav-link">Historico de movimientos</router-link>
                        </li>
                        
                        <li class="nav-item">
                            <router-link active-class="active" to="/purchase" class="nav-link">Historico de compras</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </div>

  
</template>

<script>
export default {
    name: 'AppHeader'
}
</script>

  <style scoped>
  .navbar {
    background-color: #00b19d;
    color: #ffff !important;
    padding: 10px 20px; 
    display: flex; 
    justify-content: space-between; 
  }

  .nav-link:hover {
    background-color: #168578;
  }

  .active {
    background-color: #168578;
  }

  .nav-link {
    text-decoration: none; 
    color: #fff !important; 
    padding: 10px 15px; 
    border-radius: 5px; 
    transition: background-color 0.3s ease; 
  }

</style>