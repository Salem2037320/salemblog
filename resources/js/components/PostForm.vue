<template>
    <div class="d-flex">
        <div class="row mb-2">
            <div class="col-12 text-right" :hidden="!user.isLogged" style="width : 80em;">
                <button type="button" class="btn btn-info btn-dark text-right" @click="toggleShowForm">Create New Post
                </button>
            </div>
            <div class="col-12">
                <div class="card" :hidden="!showForm">
                    <div class="card-body">
                        <form @submit.prevent="createOrUpdatePost()"
                              class="form" role="form" method="POST" enctype="multipart/form-data" style="width : 75em">
                            <input name="_token" type="hidden" v-model="user.csrfToken">
                            <input name="user_id" type="hidden" v-model="user.user_id">
                            <div class="input-group">
                                <div class="form-group">
                                    <label><h3>Title</h3></label>
                                    <input type="text" name="subject" class="form-control col-12"
                                           style="width : 75em;"
                                           v-model="post.title"
                                           required>
                                    <small class="form-text text-muted">title</small>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="form-group">
                                    <label><h4>Image</h4></label>
                                    <input type="file"
                                           class="form-control-file" name="image" @change="selectFile"
                                           required
                                    />
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="form-group">
                                    <label><h3>Content</h3></label>
                                    <textarea class="form-control"
                                              style="width : 75em;"
                                              name="article" rows="3" v-model="post.content"
                                              required>{{ post.content }}</textarea>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="form-group text-right" style="width : 75em;">
                                    <button type="submit" class="btn btn-dark">Submit</button>
                                    <button type="button" class="btn btn-light text-danger"
                                            @click="disableEditMode(false)">Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "PostForm",
        props: ['currentPost', 'fetchPosts', 'showForm', 'toggleEditMode'],
        data() {
            return {
                user: window.User,
                post: this.currentPost,
                editPost: false,
            }
        },
        created() {
        },
        methods: {
            createOrUpdatePost() {
                const formData = new FormData();
                formData.append('title', this.post.title);
                formData.append('content', this.post.content);
                formData.append('image', this.post.image);
                formData.append('user_id', this.user.user_id);
                axios.post(`api/post`, formData).then(r => {
                    this.post = {id: '', image: {}};
                    this.currentPost = {};
                }).then(() => this.fetchPosts()).catch(e => console.log('eee', e))
            },
            selectFile() {
                this.post.image = event.target.files[0];
            },
            toggleShowForm() {
                this.showForm = !this.showForm;
            },
            disableEditMode(p) {
                this.toggleEditMode(false)
                this.post = {id: '', title: '', content: '', image: {}}
            }
        }
    }
</script>

<style scoped>

</style>
