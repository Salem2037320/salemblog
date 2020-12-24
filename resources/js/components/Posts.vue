<template>
    <div>
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled : !postPagination.prevPage}]">
                    <a class="page-link" tabindex="-1"
                       @click="fetchPosts(postPagination.prevPage)">Previous</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link" tabindex="-1">Page {{ postPagination.currentPage }} of {{
                        postPagination.total }}</a>
                </li>
                <li class="page-item" v-bind:class="[{disabled : !postPagination.nextPage}]">
                    <a class="page-link" @click="fetchPosts(postPagination.nextPage)">Next</a>
                </li>
            </ul>
        </nav>
        <PostForm v-bind:currentPost="currentPost" v-bind:fetchPosts="fetchPosts" v-if="auth.user_id"
                  v-bind:showForm="showForm" v-bind:toggleEditMode="toggleEditMode"/>
        <div v-for="p in posts"
             v-bind:key="p.id"
             v-bind:posts="posts"
             class="row no-gutters bg-white border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative post-widget">
            <PostWidget v-bind:post="p" v-bind:key="p.id" v-bind:fetchPosts="fetchPosts"
                        v-bind:enableDelete="(auth.isLogged && auth.user_id === p.user_id) || auth.isAdmin"
                        v-bind:setCurrentPost="setCurrentPost"
                        v-bind:toggleEditMode="toggleEditMode"
                        v-bind:showForm="showForm"

            />
        </div>
    </div>
</template>

<script>
    import PostForm from './PostForm'
    import PostWidget from './PostWidget'
    import {isEmpty} from 'lodash';

    export default {
        name: "Posts",
        layouts: {
            PostForm,
            PostWidget
        },
        data() {
            return {
                posts: [],
                currentPost: {},
                postPagination: {},
                post_id: '',
                showForm : false,
                auth: {user_id: null, isAdmin: false, isLogged: false}
            }
        },
        mounted() {
            this.fetchPosts(),
                this.setAuth()
        },
        methods: {
            setAuth() {
                if (!isEmpty(this.$user.user_id)) {
                    this.auth = this.$user;
                }
            },
            setCurrentPost(post) {
                this.currentPost = post;
                console.log('the post', post)
            },
            toggleEditMode (d) {
                this.showForm = d ? d : !this.showForm;
            },
            fetchPosts(nextPage) {
                nextPage = nextPage || 'api/post'
                return axios.get(nextPage).then((r) => {
                    this.posts = r.data.data;
                    this.postPagination = {
                        nextPage: r.data.links.next,
                        prevPage: r.data.links.prev,
                        currentPage: r.data.meta.current_page,
                        total: r.data.meta.last_page
                    };
                }).catch(e => console.log(e))
            }
        }
    }
</script>

<style scoped>

</style>
