<div class="max-w-2xl mx-auto relative" x-data="faqSearch()">
    <div class="relative">
        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        <input
            type="text"
            x-model="searchQuery"
            @input="filterFaqs"
            placeholder="ค้นหาคำถาม..."
            class="w-full pl-12 pr-4 py-4 rounded-full border-0 text-gray-800 text-lg focus:outline-none search-focus"
        />
        <!-- Clear button -->
        <button
            x-show="searchQuery.length > 0"
            @click="clearSearch"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
        >
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Search suggestions -->
    <div x-show="searchQuery.length > 0 && suggestions.length > 0"
         class="absolute w-full mt-2 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
        <template x-for="suggestion in suggestions.slice(0, 5)" :key="suggestion.id">
            <div class="p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0"
                 @click="selectSuggestion(suggestion)">
                <p class="font-medium text-gray-800 text-sm" x-text="suggestion.question"></p>
                <p class="text-xs text-gray-500 mt-1" x-text="suggestion.category"></p>
            </div>
        </template>
    </div>
</div>

<script>
function faqSearch() {
    return {
        searchQuery: '',
        suggestions: [],
        allFaqs: @json($faqData ?? []),

        filterFaqs() {
            if (this.searchQuery.length < 2) {
                this.suggestions = [];
                return;
            }

            this.suggestions = [];
            Object.keys(this.allFaqs).forEach(categoryKey => {
                const category = this.allFaqs[categoryKey];
                category.faqs.forEach((faq, index) => {
                    if (faq.question.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        faq.answer.toLowerCase().includes(this.searchQuery.toLowerCase())) {
                        this.suggestions.push({
                            id: categoryKey + '_' + index,
                            question: faq.question,
                            category: category.title,
                            categoryKey: categoryKey
                        });
                    }
                });
            });
        },

        selectSuggestion(suggestion) {
            this.searchQuery = '';
            this.suggestions = [];
            // Scroll to the FAQ item
            setTimeout(() => {
                document.getElementById(suggestion.categoryKey).scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                // Auto-expand the selected FAQ
                this.$dispatch('expand-faq', { id: suggestion.id });
            }, 100);
        },

        clearSearch() {
            this.searchQuery = '';
            this.suggestions = [];
        }
    }
}
</script>
