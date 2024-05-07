<template>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-6 mt-4">
        <div class="mt-4">
          <div class="card-body login-style">
            <h5 class="card-title text-center"><b>Iniciar sesión</b></h5>
            <form @submit.prevent="authLogin()" method="post">

              <br>
              <div class="form-group">
                <label class="mb-2" for="email">Correo Electrónico:</label>
                <input id="email" name="email" v-model.trim="login.email" class="form-control" type="text"
                  placeholder="Correo electrónico" autocomplete="off" required>
              </div>
              <br>
              <div  class="form-group">
                <label class="mb-2"  for="password">Contraseña:</label>
                <input id="password" name="password" v-model.trim="login.password" type="password" class="form-control"
                  placeholder="Contraseña" required>
              </div>
              <br>
              <div class="form-group">
                <button type="submit" class="btn btm-alegra btn-success mt-2 py-3 px-4 ">Ingresar <i
                    class="fas fa-sign-in-alt"></i></button>
              </div>

            </form>
          </div>
        </div>
        <div v-if="progressBar" class="text-center mt-3">
          <p>Cargando...</p>
          <div class="progress mt-3" style="height: 20px;">
            <div class="progress-bar bg-progress-bar" role="progressbar"
              :style="{ width: progressBar + '%', 'background-color': '#00b19d' }" aria-valuenow="25" aria-valuemin="0"
              aria-valuemax="100">{{ progressBar }}%</div>
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
        password: '',
      },
      progressBar: 0,
      showProgreesbar: false
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
          this.progressBar = 0;
          Swal.fire({
            icon: 'error',
            text: 'Credenciales incorrectas',
          });
          return false;
        }
      } catch (error) {
        this.progressBar = 0;
        console.error('Login error:', error);
        Swal.fire({
          icon: 'error',
          text: 'Error al procesar el login',
        });
        return false;
      }
    },

    async authLogin() {
      this.showProgreesbar = true
      this.progressBar = 0;
      let loginSuccess = await this.loginMicroservice(0);

      if (loginSuccess) {
        this.progressBar = 33;
        loginSuccess = await this.loginMicroservice(1);
      }

      if (loginSuccess) {
        this.progressBar = 66;
        loginSuccess = await this.loginMicroservice(2)
        this.progressBar = 100;

      }
      if (loginSuccess) {

        setTimeout(() => {
          this.$router.push('/home');
        }, 200);


      }

    }
  }
}

</script>

<style>
.bg-progress-bar {
  background-color: #30aba9;
}

.btm-alegra {
  background-color: #30aba9 !important;
  color: #ffff;
}

.login-style {
  border: 1px solid #30aba9;
  padding: 11%;
  border-radius: 10px;
}


.btm-alegra:hover {
  background-color: #248886 !important;
  color: #ffff;
}
</style>