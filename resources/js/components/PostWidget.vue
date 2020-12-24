<template>
    <div class="row">
        <div class="col p-4 d-flex flex-column position-static">
            <h3 class="mb-0">
                {{ currentPost.title}}
            </h3>
            <div class="row border-bottom mb-3">
                <div class="col-6 mb-1 text-muted text-left">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-alarm-fill"
                         fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H9v1.07a7.001 7.001 0 0 1 3.274 12.474l.601.602a.5.5 0 0 1-.707.708l-.746-.746A6.97 6.97 0 0 1 8 16a6.97 6.97 0 0 1-3.422-.892l-.746.746a.5.5 0 0 1-.707-.708l.602-.602A7.001 7.001 0 0 1 7 2.07V1h-.5A.5.5 0 0 1 6 .5zM.86 5.387A2.5 2.5 0 1 1 4.387 1.86 8.035 8.035 0 0 0 .86 5.387zM11.613 1.86a2.5 2.5 0 1 1 3.527 3.527 8.035 8.035 0 0 0-3.527-3.527zM8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z"/>
                    </svg>
                    {{ currentPost.created_at }}
                </div>
                <div class="col-6 mb-1 text-muted text-right">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye"
                         fill="currentColor"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
                        <path fill-rule="evenodd"
                              d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                    </svg>
                    {{ currentPost.viewCount }}
                </div>
            </div>
            <p class="card-text mb-auto" style="min-width : 61em">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-text-left"
                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                </svg>
                {{ currentPost.content }}
            </p>
            <a :href="currentPost.url" class="text-right">Read More..</a>
            <div class="row mt-3" :hidden="!enableDelete">
                <div class="col-lg-12 text-right">
                    <button type="button" class="btn btn-xs btn-danger m-2" @click="deletePost(currentPost)">Delete</button>
                </div>
            </div>
        </div>
        <div class="col-auto d-none d-lg-block">
            <img
                    v-bind:src="currentPost.image"
                    class="img-thumbnail text-left" style="width: 200px"/>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PostWidget",
        props: ['post', 'setCurrentPost', 'fetchPosts', 'enableDelete','toggleEditMode', 'showForm'] ,
        data() {
            return { currentPost : this.post }
        },
        methods: {
            fetchPost(id) {
                axios.get(`api/post/`, {id}).then(r => this.post = r.data).catch(e => console.log(e))
            },
            deletePost(post) {
                if(confirm('Cofirm Delete this post ?')) {
                    axios.delete(`api/post/${post.id}`, {data: {id : post.id, api_token: this.api_token}}).then(r => {
                        this.fetchPosts()
                    }).catch(e => e);
                }
            },
            enableEditMode(post) {
                this.toggleEditMode(true);
                this.setCurrentPost(post)
                this.currentPost = post;
            }
        }
    }
</script>

<style scoped>

</style>
