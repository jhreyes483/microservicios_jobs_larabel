<template>


    <div class="container ">
        <h2 class="mb-4 mt-4">Recetas</h2>

        <div class="card card-body m-4">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="movementIngredient">Ingrediente:</label>
                    <select class="form-select" v-model="selectedIngredient" aria-label="Default select example">
                        <option v-for="ingredient in movementIngredients" :key="ingredient.id" :value="ingredient.id">{{
                            ingredient.name }}
                        </option>
                    </select>
                </div>

                <div class="col-md-3 mb-3 mt-4">
                    <label></label>
                    <button class="btn btn-alegra" style="background-color: #30aba9;   color: #ffff;"
                        @click="getRecipes">Buscar</button>
                </div>
            </div>
        </div>

        <div v-if="isLoading" class="mt-5 spinner-border text-dark" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

        <div v-else class="table-responsive ">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Ingredients</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="recipe in recipes" :key="recipe.id">
                        <td>{{ recipe.id }}</td>
                        <td>{{ recipe.name }}</td>
                        <td>
                            <ul class="list-unstyled">
                                <li v-for="ingredient in recipe.ingredients" :key="ingredient.id">
                                    {{ ingredient.name }} ({{ ingredient.pivot.recipe_quantity }})
                                </li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import updateServiceConfig from '../../../config/services';
export default {
    name: 'RecipeMain',
    data() {
        return {
            recipes: {},
            isLoading: false,
            selectedIngredient: null,
            movementIngredients: []
        }
    },
    mounted() {
        this.getComplements();
        this.getRecipes();
    },
    methods: {
        getRecipes() {
            this.isLoading = true;

            updateServiceConfig(0, this.axios);

            let postData = {
                ingredient_id: this.selectedIngredient
            };
            this.axios.post('api/recipe', postData).then(res => {
                if (res.data.status) {
                    this.isLoading = false;
                    this.recipes = res.data.recipes;
                    console.log(this.recipes)
                    this.isLoading = false;
                }
            }).catch(err => {
                this.isLoading = false;
                Swal.fire({
                    icon: 'error',
                    text: 'Error al registrar.',
                });
                console.error(err);
            });
        },
        getComplements() {
            updateServiceConfig(0, this.axios);
            this.axios.post('api/recipe/get_complements/', {}).then(res => {
                if (res.data.status) {
                    console.log(res.data.data.ingredient)
                    this.movementIngredients = res.data.data.ingredient;

                }
            }).catch(err => {
                this.isLoading = false;
                Swal.fire({
                    icon: 'error',
                    text: 'Error al registrar.',
                });
                console.error(err);
            });

        },

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