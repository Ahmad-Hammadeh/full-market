const client = algoliasearch('3N2BR9QN1R', '40535618fc16cef8ddd8bb191e9c0e71');
const products = client.initIndex('products');
let selected = false;

autocomplete('#aa-search-input', { debug: true }, {
    source: autocomplete.sources.hits(products, { hitsPerPage: 8 }),
    displayKey: 'name',
    templates: {
        suggestion(suggestion) {
            let markup = `
                <div class="result-info">
                    <span>
                        <img src="${ window.location.origin }/storage/${ suggestion.image }" alt="search result">
                        ${suggestion._highlightResult.name.value}
                    </span>
                    <span>${ moneyFormat( suggestion.price ) }</span>
                </div>
                <div class="result-details">
                    <span>${suggestion._highlightResult.details.value}</span>
                </div>
            `;
            return markup;
        },
        empty(result) {
            return `<div class="empty-search">${ lang.no_results_found_for } ${ result.query }</div>`;
        }
    }
}).on('autocomplete:selected', function(event, suggestion, dataset) {

    window.location.href = window.location.origin + '/shop/' + suggestion.slug;

    selected = true;

}).on('keyup', function(e) {
    if (e.keyCode === 13 && !selected) {

        window.location.href = window.location.origin + '/instance_search/?query=' + document.getElementById('aa-search-input').value;

    }
});
