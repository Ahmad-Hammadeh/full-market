<template>
    <ais-instant-search :search-client="searchClient" index-name="products">
        <ais-autocomplete>
            <div slot-scope="{ currentRefinement, indices, refine }">
                <input
                class="search-input"
                type="search"
                :value="currentRefinement"
                :placeholder="lang.search_for_products"
                @input="refine($event.currentTarget.value)"
                >

                <div v-if="currentRefinement" v-for="index in indices" :key="index.label">
                    <div class="aa-suggestion" v-for="hit in index.hits" :key="hit.objectID" @click="window.location.href = window.location.origin + '/shop/' + hit.slug">
                        <div class="result-info">
                            <span>
                                <img :src="window.location.origin + '/storage/' + hit.image" alt="search result">
                                <ais-highlight attribute="name" :hit="hit" highlighted-tag-name="em" />
                            </span>
                            <span>{{ moneyFormat( hit.price ) }}</span>
                        </div>
                        <div class="result-details">
                            <ais-highlight attribute="details" :hit="hit" highlighted-tag-name="em" />
                        </div>
                    </div>
                </div>

            </div>
        </ais-autocomplete>
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
        };
    },
    methods: {
        moneyFormat(price) {
            return moneyFormat( price );
        }
    },
};
</script>

<style scoped>
.aa-suggestion {
    padding: 6px 12px;
    cursor: pointer;
    -webkit-transition: .2s;
    transition: .2s;
    border-bottom: 1px solid #ccc;
}

.aa-suggestion:hover{
    background-color: rgba(241, 241, 241, 0.5);
}
.search-input {
    width: 100%;
    border-color: transparent;
    box-shadow: none; opacity: 1;
    padding: 5px;
    background: none 0% 0% / auto repeat scroll padding-box border-box rgb(255, 255, 255);
}
</style>
