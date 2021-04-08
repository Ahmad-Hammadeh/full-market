const searchClient = algoliasearch(
    '3N2BR9QN1R',
    '40535618fc16cef8ddd8bb191e9c0e71'
);

const search = instantsearch({
    indexName: 'products',
    searchClient,
    routing: {
        router: instantsearch.routers.history({
            windowTitle({ category, query }) {
                const queryTitle = query ? `Results for "${query}"` : 'Search';

                // if (category) {
                //     return `${category} – ${queryTitle}`;
                // }

                return queryTitle;
            },
            createURL({ qsModule, location, routeState }) {
                const { origin, pathname, hash } = location;
                const indexState = routeState || {};
                const queryString = qsModule.stringify(routeState);
                console.log(routeState);
                if (!indexState.query) {
                    return `${origin}${pathname}${hash}`;
                }

                return `${origin}${pathname}?${queryString}${hash}`;
            },
        }),

        stateMapping: {
            stateToRoute(uiState) {
                const indexUiState = uiState['products'] || {};

                return {
                    query: indexUiState.query,
                    page: indexUiState.page,
                };
            },

            routeToState(routeState) {

                return {
                    products: {
                        query: routeState.query,
                        page: routeState.page,
                    }
                };
            }
        }
    },
});

search.addWidgets([

    // Search Box
    instantsearch.widgets.searchBox({
        container: '#instance-search-results',
    }),

    // Stats
    instantsearch.widgets.stats({
        container: '#stats',
        templates: {
            text: `
              {{#hasNoResults}}No results{{/hasNoResults}}
              {{#hasOneResult}}1 result{{/hasOneResult}}
              {{#hasManyResults}}{{#helpers.formatNumber}}{{nbHits}}{{/helpers.formatNumber}} results{{/hasManyResults}}
              found in {{processingTimeMS}}ms
            `,
        },
        cssClasses: {
            root: 'search-stats',
        },
    }),

    // Refinement List
    instantsearch.widgets.refinementList({
        container: '#refinement-list',
        attribute: 'categories',
    }),

    // Search Result
    instantsearch.widgets.hits({
        container: '#hits',
        templates: {
            item(item) {

                return `<div class="card product">
                    <img class="card-img-top img" src="${ window.location.origin }/storage/${ item.image }"
                        alt="${ item.name }">

                    <a href="${ window.location.origin }/shop/${ item.slug }"
                        class="card-title name">${ item._highlightResult.name.value }</a>
                    <p class="card-text price">${ moneyFormat( item.price ) }</p>
                    <form action="${ window.location.origin }/cart" method="POST">
                        <input type="hidden" name="_token" value="${ document.querySelector('meta[name="csrf-token"]').content }">
                        <input type="hidden" name="id" value="${ item.id }">
                        <input type="hidden" name="name" value="${ item.name }">
                        <input type="hidden" name="price" value="${ item.price }">
                        <button type="submit"
                            class="add-to-card btn btn-success btn-block btn-sm">${ lang.add_to_cart } <i
                                class="fa fa-shopping-cart"></i></button>
                    </form>
                </div>`;

            },

            empty: '<div>' + lang.no_results_found_for + ' {{ query }}</div>.'
        },
        cssClasses: {
            root: 'products text-center pt-3',
            list: 'row',
            item: ['search-item', 'col-sm-6', 'col-lg-4'],
        },
    }),

    // Pagination
    instantsearch.widgets.pagination({
        container: '#pagination',
        padding: 1,
        showPrevious: false,
        showNext: false,
    }),

    instantsearch.widgets.configure({
        hitsPerPage: 8
    }),
]);

search.start();