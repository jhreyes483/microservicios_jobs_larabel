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
                <button type="submit" class="btn btm-alegra btn-success mt-2"> Ingresar <i class="fas fa-sign-in-alt"></i></button>
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
import {updateServiceConfig } from '../../../config/services';
export default {
  name: "LoginUser",
  data() {
    return {
      isLoginFull: true,
      emailRegex: /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i,
      login: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
    authLogin() {
      var isLoginFull = true;
      updateServiceConfig(0, this.axios);

      var data = {
        email: this.login.email,
        password: this.login.password
      }
      console.log(data, 'data');
      this.axios.post('api/login', data).then(res => {
        if (res.data.status == "success") {
          console.log('t0--->>>', res.data.authorisation.token)
          localStorage.setItem('access_token_0', res.data.authorisation.token);
        } else {
          isLoginFull = false;
          Swal.fire({
            icon: 'error',
            text: 'Credenciales incorrectas',
          });

        }
      })

      updateServiceConfig(1, this.axios);
      this.axios.post('api/login', data).then(res => {
        if (res.data.status == "success") {
          console.log('t2--->>>', res.data.authorisation.token)
          localStorage.setItem('access_token_1', res.data.authorisation.token);
        } else {
          isLoginFull = false;
          Swal.fire({
            icon: 'error',
            text: 'Credenciales incorrectas',
          });
        }
      })

      updateServiceConfig(2, this.axios);
      this.axios.post('api/login', data).then(res => {
        if (res.data.status == "success") {
          console.log('s1--->>>', res.data.authorisation.token)
          localStorage.setItem('access_token_3', res.data.authorisation.token);


        } else {
          isLoginFull = false;
          Swal.fire({
            icon: 'error',
            text: 'Credenciales incorrectas',
          });
        }
      })

      setTimeout(() => {
        if (isLoginFull) {
          this.$router.push('/home');
        }
      }, 3000);


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