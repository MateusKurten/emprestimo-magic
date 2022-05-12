<script>
    function select(config) {
        return {
            data: config.data,
            emptyOptionsMessage: config.emptyOptionsMessage ?? 'Nenhum resultado com a busca',
            focusedOptionIndex: null,
            name: config.name,
            open: false,
            options: {},
            placeholder: config.placeholder ?? 'Selecione uma opção',
            search: '',
            multiple: config.multiple ?? true,
            value: config.value ?? '',
            closeListbox: function () {
                this.open = false
                this.focusedOptionIndex = null
                this.search = ''
            },
            focusNextOption: function () {
                if (this.focusedOptionIndex === null) return this.focusedOptionIndex = Object.keys(this.options).length - 1

                if (this.focusedOptionIndex + 1 >= Object.keys(this.options).length) return

                this.focusedOptionIndex++
                this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                    block: "center",
                })
            },
            focusPreviousOption: function () {
                if (this.focusedOptionIndex === null) return this.focusedOptionIndex = 0

                if (this.focusedOptionIndex <= 0) return

                this.focusedOptionIndex--
                this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                    block: "center",
                })
            },
            init: function () {
                this.options = this.data

                this.$watch('search', ((value) => {
                    if (!this.open || !value) return this.options = this.data

                    this.options = Object.keys(this.data)
                        .filter((key) => this.data[key].toLowerCase().includes(value.toLowerCase()))
                        .reduce((options, key) => {
                            options[key] = this.data[key]
                            return options
                        }, {})
                }))
            },
            selectOption: function () {
                if (!this.open) return this.toggleListboxVisibility()

                if (this.multiple) {
                    let value = typeof this.value == 'string' && this.value
                    ? this.value.split(',')
                    : [];

                    if (value.indexOf(Object.keys(this.options)[this.focusedOptionIndex]) === -1) {
                        value.push(Object.keys(this.options)[this.focusedOptionIndex]);
                    } else {
                        value = value.filter(e => e !== Object.keys(this.options)[this.focusedOptionIndex])
                    }

                    this.value = value.join(',');
                    this.closeListbox()
                } else {
                    this.value = this.value == Object.keys(this.options)[this.focusedOptionIndex]
                        ? ''
                        : Object.keys(this.options)[this.focusedOptionIndex];
                }
            },
            toggleListboxVisibility: function () {
                if (this.open) return this.closeListbox()

                let value = typeof this.value == 'string' && this.value
                    ? this.value.split(',')
                    : [];

                this.focusedOptionIndex = Object.keys(this.options).indexOf(value.at(-1))

                if (this.focusedOptionIndex < 0) this.focusedOptionIndex = 0

                this.open = true
                this.$nextTick(() => {
                    this.$refs.search.focus()

                    this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                        block: "center"
                    })
                })
            },
            maskedInput: function() {
                let value = typeof this.value == 'string' && this.value
                    ? this.value.split(',')
                    : [];

                if (!value) return ''

                const filtered = Object.entries(this.data).filter(([key]) => value.indexOf(key) !== -1).map((i) => i[1]);

                return filtered.join(',');
            }
        }
    }
</script>
<div
    x-data="select({
        data: {{ $data }},
        name: '{{ $name }}',
        value: '{{ $value ?? old($name) }}',
        multiple: {{ $multiple }},
        emptyOptionsMessage: {{ $emptyOptionsMessage }},
        placeholder: {{ $placeholder }}
    })"
    x-init="init()"
    @click.away="closeListbox()"
    @keydown.escape="closeListbox()"
    class="relative"
>
    <span class="inline-block w-full rounded-md shadow-sm">
        <button
            type="button"
            x-ref="button"
            @click="toggleListboxVisibility()"
            :aria-expanded="open"
            aria-haspopup="listbox"
            class="relative z-0 form-select bg-gray-200 border-gray-300 focus:border-indigo-400 focus:shadow-none focus:bg-white mt-1 block w-full"
        >
            <span
                x-show="! open"
                x-text="value ? maskedInput() : placeholder"
                :class="{ 'text-gray-500': ! value }"
                class="block truncate text-left p-2"
            ></span>

            <input
                name="{{ $name }}"
                x-model="value"
                class="hidden p-2"
            />

            <input
                x-ref="search"
                x-show="open"
                x-model="search"
                @keydown.enter.stop.prevent="selectOption()"
                @keydown.arrow-up.prevent="focusPreviousOption()"
                @keydown.arrow-down.prevent="focusNextOption()"
                type="search"
                class="w-full h-full form-control focus:outline-none p-2 border-none"
            />
        </button>
    </span>

    <div
        x-show="open"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak
        class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg p-2"
    >
        <ul
            x-ref="listbox"
            @keydown.enter.stop.prevent="selectOption()"
            @keydown.arrow-up.prevent="focusPreviousOption()"
            @keydown.arrow-down.prevent="focusNextOption()"
            role="listbox"
            :aria-activedescendant="focusedOptionIndex ? name + 'Option' + focusedOptionIndex : null"
            tabindex="-1"
            class="py-1 overflow-auto text-base leading-6 rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5"
        >
            <template x-for="(key, index) in Object.keys(options)" :key="index">
                <li
                    :id="name + 'Option' + focusedOptionIndex"
                    @click="selectOption()"
                    @mouseenter="focusedOptionIndex = index"
                    @mouseleave="focusedOptionIndex = null"
                    role="option"
                    :aria-selected="focusedOptionIndex === index"
                    :class="{ 'text-white bg-indigo-600': index === focusedOptionIndex, 'text-gray-900': index !== focusedOptionIndex }"
                    class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9"
                >
                    <span x-text="Object.values(options)[index]"
                        :class="{ 'font-semibold': index === focusedOptionIndex, 'font-normal': index !== focusedOptionIndex }"
                        class="block font-normal truncate"
                    ></span>
                    <span
                        x-show="value.split(',').indexOf(key) !== -1"
                        :class="{ 'text-white': index === focusedOptionIndex, 'text-indigo-600': index !== focusedOptionIndex }"
                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"/>
                        </svg>
                    </span>
                </li>
            </template>

            <div
                x-show="! Object.keys(options).length"
                x-text="emptyOptionsMessage"
                class="px-3 py-2 text-gray-900 cursor-default select-none">
            </div>
        </ul>
    </div>
</div>
