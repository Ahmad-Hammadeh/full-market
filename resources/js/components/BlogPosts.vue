<template>
    <section class="blog-posts section text-center">
        <div class="container">
            <h2 class="section-title">{{ lang.latest_posts }}   </h2>
            <p class="section-desc text-justify">
                {{ lang.medium_lorem }}
            </p>
            <div class="row" v-if="posts.length > 0">
                <div class="post-container col-md-6 col-lg-4" v-for="post in posts" :key="post.id">
                    <div class="card post">
                        <!-- <img
                            src="storage/general/header.webp"
                            alt="post"
                        /> -->
                        <blog-image :url="post._links['wp:featuredmedia'][0].href"></blog-image>
                        <div class="card-body">
                            <h5 class="card-title">{{ post.title.rendered }}</h5>
                            <p class="card-text text-justify">
                                {{ stripHtml(post.content.rendered) }}
                                <a :href="post.link"> ... {{ lang.more }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <p class="message h4" v-else>{{ lang.no_posts }}</p>
        </div>
    </section>
</template>

<script>
import BlogImage from './BlogImage';
import sanitizeHtml from 'sanitize-html';

export default {
    data() {
        return {
            lang: lang,
            // window: window,
            // token: document.querySelector('meta[name="csrf-token"]').content,
            posts: [],
        };
    },
    methods: {
        stripHtml(string) {

            return sanitizeHtml(string, { allowedTags: [] }).substr(0, 300);

        }
    },
    components: {
        BlogImage,
    },
    created() {
        axios
            .get('https://blog.laravelecommerceexample.ca/wp-json/wp/v2/posts?per_page=3')
            .then( response => this.posts = response.data )
    }
};
</script>

<style></style>
