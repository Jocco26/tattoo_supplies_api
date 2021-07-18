<template>
    <div>
        <div class="container form">
        <form @submit.prevent="addProduct" enctype="multipart/form-data">
            <div class="form-group">
              <label for="cat_name">Product Name</label>
              <input id="cat_name" type="text" name="name" class="form-control" v-model="product.name">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" class="form-control" name="description"  rows="3" v-model="product.description"></textarea>
            </div>

            <div class="form-group">
                <label for="product_category">Category</label>
                <select id="product_category" class="form-control" name="category" @change="getValue($event)">
                        <option value="null" selected disabled>Select a Category</option>
                        <option id="category_id" v-for="category in categories" v-bind:key="category.id" :value="category.id">{{ category.name }}</option>
                </select>
              </div>

            <div class="form-group">
                <label for="img">Image</label>
                <input id="img" type="file" name="image" class="form-control-file" @change="onChange">
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
                    <button @click="editProduct(product)" class="btn btn-warning">Edit</button>
                    <button @click="deleteProduct(product.id)" class="btn btn-danger">Delete</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

    export default{
        data() {
            return{
                products:[],
                product:{
                    id:'',
                    name:'',
                    description:'',
                    category_id:'',
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
            onChange(e){
                //console.log("selected file", e.target.files[0]);
                this.image = e.target.files[0];

                console.log(this.image);
            },
            getValue(event){
                this.category_id = event.target.value;
                console.log(this.category_id)
                
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
            },
            addProduct(){
               
                if(this.edit === false){

                    let data = new FormData();
                    data.append('name', this.product.name);
                    data.append('description', this.product.description);
                    data.append('category_id', this.category_id);
                    data.append('image', this.image);

                    axios.post("api/products02/new",data).then(res=>{
                        console.log("Response", res.data)
                    }).catch(err=>console.log(err))
                    
                }else{
                    let data = new FormData();
                    data.append('name', this.product.name);
                    data.append('description', this.product.description);
                    data.append('category_id', this.category_id);
                    data.append('product_id', this.product.product_id);
                    data.append('image', this.image);
                    
                    console.log(this.product.product_id)
                    axios.put("api/products02/new",data).then(res=>{
                        console.log("Response", res.data)
                    }).catch(err=>console.log(err))
                }
            },
            editProduct(product){
                this.edit = true;
                this.product.id = product.id;
                this.product.product_id = product.id;
                this.product.name = product.name;
                this.product.description = product.description;
                document.getElementById('product_category').selectedIndex=product.category_id;
                console.log(this.product.id)
                console.log(this.product.product_id)

            }
        }
    };
</script>   
<style>
        img{
            width: 80%;
        }

        .form{
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .form button{
            margin-top: 20px;
        }
    </style>
