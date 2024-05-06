<template>

  <br>
  <AppSlider :showBtn="true" texto="Inicio"></AppSlider>

  <div class="col-md-8 mx-auto ">
    <br>
    <div class="btn btm-alegra my-1" @click="askForOrder"> Ordenar un plato <i class="fas fa-utensils"></i></div>
    <br>
    <div v-if="progressBar" class="progress mt-4" style="height: 20px;">
      <div class="progress-bar bg-success" role="progressbar" :style="{ width: progressBar + '%' }" aria-valuenow="25"
        aria-valuemin="0" aria-valuemax="100">{{ progressBar }}%</div>
    </div>
  </div>




</template>
<script>
import AppSlider from '../AppSlider.vue';
import { updateServiceConfig } from '../../../config/services';
import Swal from 'sweetalert2';
export default {



  name: 'HomeMain',
  components: {
    AppSlider
  },
  data() {
    return {
      progressBar: 0,

      selectedValues: [],
      selectedOption: '',

    };
  },
  methods: {
    askForOrder() {
      this.progressBar = 10;
      console.log("aca");
      updateServiceConfig(0, this.axios);

      this.axios.post('api/orders', {}).then(res => {
        this.progressBar = 20;
        if (res.data.status) {
          this.progressBar = 60;
          const url = `/order?id=${res.data.order_id}`;
          this.progressBar = 100;
          Swal.fire({
            icon: 'success',
            text: res.data.msg,
            footer: `<a href="${url}">Ver orden</a>`
          }).then((result) => {
            if (result.isConfirmed) {

              setTimeout(() => {
                this.progressBar = 0;
              }, 400);

            }

          });
        }
      }).catch(err => {
        Swal.fire({
          icon: 'error',
          text: 'Error en petición.',
        });
        console.error(err);
      });
    }


  }
};


</script>
