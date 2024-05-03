<template>

  <div class="mt-4">
    <h4>Estado de compras en espera</h4>
  </div>

    <div class="container-fluid mt-4 col-md-9">
        <div>


      

            <div>
                <div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Model ID</th>
                                <th>Retry</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="purchase in purchases" :key="purchase.id">
                                <td>{{ purchase.id }}</td>
                                <td>{{ purchase.model_id }}</td>
                                <td>{{ purchase.retry }}</td>
                                <td :style="{ background: purchase.status.color }">{{ purchase.status.name }}</td>
                                <td>{{ purchase.type.name }}</td>
                                <td>{{ new Date(purchase.created_at).toLocaleDateString() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>

</template>

<script>
import Swal from 'sweetalert2';
import updateServiceConfig from '../../../config/services';
export default {
    name: "HistoricalPurchase",
    data() {
        return {
            purchases: {}

        };
    },
    mounted() {
        this.getPurchases()
    },
    methods: {

        getPurchases() {
            updateServiceConfig(1, this.axios);
            this.axios.post('api/get_purchase/', {}).then(res => {
                if (res.data.status) {
                    console.log(res.data.purchases.data)
                    this.purchases = res.data.purchases.data;
                    //this.movementTypes = res.data.data.types;
                    //this.movementReasons = res.data.data.reasons;
                    //this.movementIngredients = res.data.data.ingredient;
                }
            }).catch(err => {
                this.isLoading = false;
                Swal.fire({
                    icon: 'error',
                    text: 'Error al registrar.',
                });
                console.error(err);
            });
        }
    }

}
</script>