<template>
    <div>
        {{ counter }}
        <button @click="updateCounter(1)">Ingrease</button>
        <button @click="updateCounter(-1)">Decrease</button>
        <br /><br />
        <div v-for="(blog, i) in blogs" :key="i" v-if="blogs.length">
            <h1>{{ blog.title }}</h1>
            <p>{{ blog.post }}</p>
        </div>
        <br /><br />
        <div>
            <h1 v-if="showItem">Aparecera si es verdadero</h1>

            <h1 v-else>Aparecera si es falso</h1>
        </div>
        <button @click="change()">Change showitem</button>
    </div>
</template>
<script>
export default {
    data() {
        return {
            views: 0,
            blogs: [],
            showItem: false
        };
    },
    methods: {
        updateCounter(number) {
            this.views += number;
        },
        change() {
            this.showItem = !this.showItem;
        }
    },
    created() {
        this.views = 100;
        let posts = [
            { title: "Title 1", post: "This is the blog post 1", id: 1 },
            { title: "Title 2", post: "This is the blog post 2", id: 2 },
            { title: "Title 3", post: "This is the blog post 3", id: 3 },
            { title: "Title 4", post: "This is the blog post 4", id: 4 }
        ];
        this.blogs = posts;
    }
};
</script>
