<template>
  <AppSlider :showBtn="true" texto="Inicio"></AppSlider>
  <div class="col-md-8 mx-auto">

    <div class="btn btn-primary my-1" @click="askForOrder"> Ordenar un plato </div>
    <br>

  </div>
</template>
<script>
import AppSlider from '../AppSlider.vue';
import updateServiceConfig from '../../../config/services';
import Swal from 'sweetalert2';
export default {



  name: 'HomeMain',
  components: {
    AppSlider
  },
  data() {
    return {
      selectedValues: [],
      selectedOption: '', // Almacena la opción seleccionada
    };
  },
  methods: {
    askForOrder() {
      console.log("aca");
      updateServiceConfig(0, this.axios);

      this.axios.post('api/orders', {}).then(res => {
        if (res.data.status) {
          const url = `/order?id=${res.data.order_id}`;
          Swal.fire({
            icon: 'success',
            text: res.data.msg,
            footer: `<a href="${url}">Ver orden</a>`
          });
        }
      }).catch(err => {
        Swal.fire({
          icon: 'error',
          text: 'Error al registrar.',
        });
        console.error(err); 
      });
    }


  }
};


</script>
