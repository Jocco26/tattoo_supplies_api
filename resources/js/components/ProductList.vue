<template>
    <div>
        <div class="container form">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="cat_name">Product Name</label>
              <input id="cat_name" type="text" name="name" class="form-control" >
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" class="form-control" name="description"  rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="product_category">Category</label>
                <select id="product_category" class="form-control" name="category">
                        <option v-for="category in categories" v-bind:key="category.id" :value="category.id">{{ category.name }}</option>
                </select>
              </div>

            <div class="form-group">
                <label for="img">Image</label>
                <input id="img" type="file" name="image" class="form-control-file" >
            </div>
              
            

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
      

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchProducts(pagination.prev_page_url)">Previous</a></li>
                
                <li class="page-item disabled"><a class="page-link text-dark" href="#">
                    Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchProducts(pagination.next_page_url)">Next</a></li>
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
                    <hr>
                    <button @click="deleteProduct(product.id)" class="btn btn-danger">Delete</button>
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
                categories:[],
                category:{
                    id:'',
                    name:''   
                },
                product_id:'',
                pagination:{},
                edit:false
            }
        },

        created(){
            this.fetchProducts();
            this.fetchCategory();
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
            fetchCategory(){
                fetch('api/categories02')
                .then(res => res.json())
                .then(res => {
                    this.categories = res.data;
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
            },
            deleteProduct(id){
                if(confirm('Are you sure')){
                    fetch(`api/products02/${id}`, {
                        method:'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Product Removed');
                        this.fetchProducts(); 
                    })
                    .catch(err => console.log(err));
                }
            }
        }
    };
</script>
<style>
        img{
            width: 50%;
        }

        .form{
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .form button{
            margin-top: 20px;
        }
    </style>
