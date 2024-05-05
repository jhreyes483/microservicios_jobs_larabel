<template>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-6 mt-4">
        <div class="mt-4">
          <div class="card-body">
            <h5 class="card-title text-center"><b>Iniciar Sesión</b></h5>
            <form @submit.prevent="authLogin()" method="post">

              <br>
              <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input id="email" name="email" v-model.trim="login.email" class="form-control" type="text"
                  placeholder="Correo electrónico" autocomplete="off" required>
              </div>
              <br>
              <div class="form-group">
                <label for="password">Contraseña:</label>
                <input id="password" name="password" v-model.trim="login.password" type="password" class="form-control"
                  placeholder="Contraseña" required>
              </div>
              <br>
              <div class="form-group">
                <button type="submit" class="btn btm-alegra btn-success mt-2"> Ingresar <i
                    class="fas fa-sign-in-alt"></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <br>
  </div>
</template>

<script>
import Swal from 'sweetalert2';
import { updateServiceConfig } from '../../../config/services';

export default {
  name: "LoginUser",
  data() {
    return {
      login: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
    async loginMicroservice(codeMicoService) {
      updateServiceConfig(codeMicoService, this.axios);
      const data = {
        email: this.login.email,
        password: this.login.password
      };

      try {
        const response = await this.axios.post('api/login', data);
        if (response.data.status === "success") {
          console.log('t-->>>' + codeMicoService, response.data.authorisation.token);
          localStorage.setItem('access_token_' + codeMicoService, response.data.authorisation.token);
          return true;
        } else {
          Swal.fire({
            icon: 'error',
            text: 'Credenciales incorrectas',
          });
          return false;
        }
      } catch (error) {
        console.error('Login error:', error);
        Swal.fire({
          icon: 'error',
          text: 'Error al procesar el login',
        });
        return false;
      }
    },

    async authLogin() {
      let loginSuccess = await this.loginMicroservice(0);
      if (loginSuccess) loginSuccess = await this.loginMicroservice(1);
      if (loginSuccess) loginSuccess = await this.loginMicroservice(2);
      if (loginSuccess) this.$router.push('/home');
    }
  }
}
</script>

<style>
.btm-alegra {
  background-color: #30aba9 !important;
  color: #ffff;
}


.btm-alegra:hover {
  background-color: #248886 !important;
  color: #ffff;
}
</style>