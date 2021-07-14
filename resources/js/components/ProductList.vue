<template>
    <div>
    <h2>Product list</h2>
        <div class="card card-body" v-for="product in products" v-bind:key="product.id">
            <h3>{{ product.name }}</h3>
            <p>{{ product.description }}</p>
            <p>{{ product.image }}</p>
        </div>
    </div>
</template>
<script>
    export default{
        data() {
            return{
                products:[],
                product:{
                    id:'',
                    title:'',
                    description:''
                },
                product_id:'',
                pagination:{},
                edit:false
            }
        },

        created(){
            this.fetchProducts();
        },

        methods:{
            fetchProducts() {
                fetch('api/products02')
                .then(res => res.json())
                .then(res => {
                    this.products = res.data;
                });
            }
        }
    }
</script>
