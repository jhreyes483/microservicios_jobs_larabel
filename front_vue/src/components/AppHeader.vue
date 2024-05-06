<template>
    <div class="">
        <nav class="navbar navbar-expand-lg navbar-light bg-light ">
            <div class="container-fluid navbar">
                <div>
                    <img class="avatar_mask" alt="Alegra"
                        src="https://th.bing.com/th/id/OIP.qMRX44T-Qs-bBhYUIDnj-QAAAA?rs=1&pid=ImgDetMain">
                </div>
                <b>Alegra</b> &nbsp; Reto restaurante
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    </ul>
                    <ul class="navbar-nav navbar-right mr-auto">
                        <li class="nav-item" v-if="checkToken">
                            <router-link active-class="active" to="/home" class="nav-link">inicio</router-link>
                        </li>
                        <li class="nav-item" v-if="checkToken">
                            <router-link active-class="active" to="/orders" class="nav-link">Ordenes</router-link>
                        </li>
                        <li class="nav-item" v-if="checkToken">
                            <router-link active-class="active" to="/recipe" class="nav-link">Recetas</router-link>
                        </li>
                        <li class="nav-item" v-if="checkToken">
                            <router-link active-class="active" to="/history_movoments" class="nav-link">Historico de
                                movimientos</router-link>
                        </li>
                        <li class="nav-item" v-if="checkToken">
                            <router-link active-class="active" to="/purchase" class="nav-link">Historico de
                                compras</router-link>
                        </li>
                        <li class="nav-item" v-if="checkToken">
                            <router-link active-class="active" to="/marker" class="nav-link">Plaza
                                inventario</router-link>
                        </li>
                        <li v-if="checkToken" class="nav-item">
                            <div @click="logout()" class="nav-link">Cerrar sesion</div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
import { existToken } from '../polices/auth'
import Swal from 'sweetalert2';
export default {
    name: 'AppHeader',
    data() {

        return {
            checkToken: existToken(),
        }

    },
    watch: {
        '$route': function () {
            this.checkToken = existToken();
        },
    },
    methods: {
        logout() {
            localStorage.removeItem('access_token_0');
            localStorage.removeItem('access_token_1');
            localStorage.removeItem('access_token_2');

            Swal.fire({
                icon: 'success',
                title: 'Sesión cerrada',
                text: 'Has cerrado sesión correctamente.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$router.push('/').catch(err => {
                        console.error("Error al navegar:", err);
                    });
                }
                this.checkToken = false;
            });
        },
        isLoginRoute() {
            return this.$route.path === '/';
        }

    },


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