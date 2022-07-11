<template>
 <div class="my-blogs-container">
     <h1>My blogs:</h1>
     <ul class="list-group my-blogs-list">
         <li v-for="blog in blogs"
             class="list-group-item">
             {{blog.title}}
             <div>
                 <button @click="showBlog(blog.id)" class="btn btn-outline-info">Show</button>
                 <button @click="deleteBlog(blog.id)" class="btn btn-outline-danger">Delete</button>
             </div>
         </li>
     </ul>
 </div>
</template>

<script>
import router from "../../router";

export default {
    name: "MyBlogs",
    data() {
        return {
            blogs: []
        }
    },
    mounted() {
        axios.get('/api/user_blogs')
            .then(r => {
                this.blogs = r.data.data
            })
            .catch(e => console.log(e.response))
    },
    methods: {
        showBlog(id) {
            router.push('/blog/' + id)
        },
        deleteBlog(id) {
            axios.delete('/api/blog/' + id)
                .then(r => {
                    let i = this.blogs.findIndex(blog => blog.id === id)
                    this.blogs.splice(i, 1)
                })
                .catch(e => console.log(e.response))
        }
    }
}
</script>

<style scoped>
.my-blogs-container {
    color: #EBE8EF;
    padding: 50px;
}
.my-blogs-list {

}
.my-blogs-list > .list-group-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #38314b;
    color: #EBE8EF;
    min-width: 350px;
}
.my-blogs-list > .list-group-item > div > .btn {
    font-size: 14px;
    padding: 5px 10px;
    border-radius: 10px;
}
.my-blogs-list > .list-group-item:hover {
    background-color: #442a4f;
}
</style>
