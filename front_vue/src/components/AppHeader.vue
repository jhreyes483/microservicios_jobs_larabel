<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
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


                        <!-- 
                        <li class="nav-item">
                            <router-link active-class="active" to="/peliculas" class="nav-link">Peliculas</router-link>
                        </li>
 

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item">Panel de usuarios</a></li>
                                <li><a class="dropdown-item" href="#">Mi perfil</a></li>
                                <li><a class="dropdown-item">Ajustes</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item pointer">Cerrar sesión</a></li>
                            </ul>
                        </li>
                        -->
                    </ul>
                </div>
            </div>
        </nav>

    </div>

    <!-- 
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>


     -->
</template>

<script>
export default {
    name: 'AppHeader'
}
</script>