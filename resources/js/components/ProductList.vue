<template>
    <div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a></li>
                
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Next</a></li>
            </ul>
        </nav>

        <div class="card mb-3" style="max-width: 540px;" v-for="product in products" v-bind:key="product.id">
            <div class="row no-gutters">
                <div class="col-md-4">
                <img class="card-img" :src="'/storage/images/products/' + product.image" alt="...">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ product.name }}</h5>
                    <p class="card-text">{{ product.description }}</p>
                </div>
                </div>
            </div>
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
                    description:'',
                    image:''
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
            fetchProducts(page_url) {
                let vm = this;
                page_url = page_url || 'api/products02'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.products = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
            },
            makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                }

                this.pagination = pagination;
            }
        }
    };
</script>
<style>
        img{
            width: 50%;
        }
    </style>
