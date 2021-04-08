<template>
    <ais-instant-search :search-client="searchClient" index-name="products">
        <div class="row">
            <div class="col-md-3">
                <ais-search-box :placeholder="lang.search_for_products"/>
                <ais-stats
                    :class-names="{
                        'ais-Stats': 'search-stats',
                    }"
                />
                <ais-refinement-list attribute="categories" />

            </div>
            <div class="col-md-9">
                <ais-hits>

                    <div class="products text-center" slot-scope="{ items }">
                        <div class="row">
                            <div class="col-sm-6 col-lg-4" v-for="item in items" :key="item.objectID">
                                <div class="card product">

                                    <img class="card-img-top img" :src="window.location.origin + '/storage/' + item.image"
                                        :alt="item.name">

                                    <a :href="window.location.origin + '/shop/' + item.slug" class="card-title name">
                                        <ais-highlight attribute="name" :hit="item" highlighted-tag-name="em" />
                                    </a>
                                    <p class="card-text price">{{ moneyFormat( item.price ) }}</p>
                                    <form :action="window.location.origin + '/cart'" method="POST">
                                        <input type="hidden" name="_token" :value="token">
                                        <input type="hidden" name="id" :value="item.id">
                                        <input type="hidden" name="name" :value="item.name">
                                        <input type="hidden" name="price" :value="item.price">
                                        <button type="submit"
                                            class="add-to-card btn btn-success btn-block btn-sm">{{ lang.add_to_cart }} <i
                                                class="fa fa-shopping-cart"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </ais-hits>

                <ais-pagination
                    :show-previous="false"
                    :show-next="false"
                    :padding="1"
                />
            </div>
        </div>
        <ais-configure
            :hitsPerPage="8"
        />
    </ais-instant-search>
</template>

<script>
import algoliasearch from "algoliasearch/lite";

export default {
    data() {
        return {
            searchClient: algoliasearch(
                "3N2BR9QN1R",
                "40535618fc16cef8ddd8bb191e9c0e71"
            ),
            lang: lang,
            window: window,
            token: document.querySelector('meta[name="csrf-token"]').content,
        };
    },
    methods: {
        moneyFormat(price) {
            return moneyFormat( price );
        }
    },
};
</script>
