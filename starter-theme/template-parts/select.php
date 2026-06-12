<?php
if ( ! isset( $select ) || ! is_array( $select ) ) {
	$select = get_query_var( 'select' );
}

if ( empty( $select ) || ! is_array( $select ) ) {
	return;
}

$id                 = isset( $select['id'] ) ? (string) $select['id'] : wp_unique_id( 'starter-theme-select-' );
$name               = isset( $select['name'] ) ? (string) $select['name'] : 'starter_theme_select';
$field_label        = isset( $select['field_label'] ) ? (string) $select['field_label'] : '';
$placeholder        = isset( $select['placeholder'] ) ? (string) $select['placeholder'] : '';
$search_placeholder = isset( $select['search_placeholder'] ) ? (string) $select['search_placeholder'] : '';
$required           = ! empty( $select['required'] );
$disabled           = ! empty( $select['disabled'] );
$multiple           = ! empty( $select['multiple'] );
$open               = ! empty( $select['open'] );
$searchable         = array_key_exists( 'searchable', $select ) ? (bool) $select['searchable'] : true;
$options            = isset( $select['options'] ) && is_array( $select['options'] ) ? $select['options'] : array();
$selected           = isset( $select['selected'] ) && is_array( $select['selected'] ) ? $select['selected'] : array();
$wrapper_class      = isset( $select['wrapper_class'] ) ? (string) $select['wrapper_class'] : '';
$dropdown_class     = isset( $select['dropdown_class'] ) ? (string) $select['dropdown_class'] : '';
$input_name         = $multiple ? $name . '[]' : $name;
$options_json       = wp_json_encode( array_values( $options ) );
$selected_json      = wp_json_encode( array_values( $selected ) );

?>
<div
	class="starter-theme-select relative <?php echo esc_attr( $wrapper_class ); ?> <?php echo $disabled ? 'pointer-events-none opacity-70' : ''; ?>"
	data-options="<?php echo esc_attr( $options_json ); ?>"
	data-selected="<?php echo esc_attr( $selected_json ); ?>"
	data-placeholder="<?php echo esc_attr( $placeholder ); ?>"
	@click.outside="open = false"
	x-data="{
		open: <?php echo $open ? 'true' : 'false'; ?>,
		search: '',
		loading: false,
		searchTimeout: null,
		multiple: <?php echo $multiple ? 'true' : 'false'; ?>,
		options: JSON.parse($el.dataset.options || '[]'),
		selected: JSON.parse($el.dataset.selected || '[]'),
		placeholder: $el.dataset.placeholder || '',
		init() {
			this.$watch('search', (value) => {
				if (this.searchTimeout) clearTimeout(this.searchTimeout);
				if (value) {
					this.loading = true;
					this.searchTimeout = setTimeout(() => {
						this.loading = false;
					}, 500);
				} else {
					this.loading = false;
				}
			});
		},
		get filteredOptions() {
			if (!this.search) return this.options;
			return this.options.filter((option) => option.label.toLowerCase().includes(this.search.toLowerCase()));
		},
		isSelected(value) {
			return this.selected.includes(value);
		},
		toggleOption(value) {
			if (this.multiple) {
				if (this.isSelected(value)) {
					this.selected = this.selected.filter((item) => item !== value);
				} else {
					this.selected = [...this.selected, value];
				}
				return;
			}
			this.selected = [value];
			this.open = false;
		},
		removeOption(value) {
			this.selected = this.selected.filter((item) => item !== value);
		},
		selectedLabel(value) {
			const found = this.options.find((option) => option.value === value);
			return found ? found.label : value;
		},
		get singleLabel() {
			if (!this.selected.length) return '';
			return this.selectedLabel(this.selected[0]);
		}
	}"
>
	<div class="rounded-[14px] border border-starter-btn-primary-disabled bg-white shadow-[0_2px_10px_rgba(15,23,42,0.06)]">
		<button
			type="button"
			class="flex min-h-[56px] w-full items-center justify-between gap-3 px-4 py-2.5 text-left"
			@click="open = !open"
			aria-haspopup="listbox"
			:aria-expanded="open"
			<?php echo $disabled ? 'disabled' : ''; ?>
		>
			<span class="min-w-0 flex-1">
				<?php if ( '' !== $field_label ) : ?>
					<span class="mb-0.5 block text-[0.82rem] leading-4 text-starter-icon-subdued">
						<?php echo esc_html( $field_label ); ?><?php if ( $required ) : ?><span class="text-[#ef4444]"> *</span><?php endif; ?>
					</span>
				<?php endif; ?>
				<?php if ( $multiple ) : ?>
					<span class="flex flex-wrap items-center gap-1.5">
						<template x-if="selected.length === 0">
							<span class="text-[0.95rem] leading-5 text-starter-text-black"><?php echo esc_html( $placeholder ); ?></span>
						</template>
						<template x-for="value in selected" :key="value">
							<span class="inline-flex items-center gap-1 rounded-full bg-starter-btn-secondary-disabled px-2 py-0.5 text-[0.82rem] leading-4 text-starter-text-black">
								<span x-text="selectedLabel(value)"></span>
								<button type="button" class="inline-flex items-center justify-center text-starter-icon-subdued" @click.stop="removeOption(value)">
										<span class="w-3 h-3 flex items-center justify-center">
											<i class="ri-arrow-right-line"></i>
										</span>
								</button>
							</span>
						</template>
					</span>
				<?php else : ?>
					<span class="block text-[0.95rem] leading-5 text-starter-text-black" x-text="singleLabel || placeholder"></span>
				<?php endif; ?>
			</span>
			<span class="inline-flex h-6 w-6 shrink-0 items-center justify-center text-starter-icon-subdued transition-transform" :class="open ? 'rotate-180' : ''">
								<span class="w-3 h-3 flex items-center justify-center">
									<i class="ri-arrow-right-line"></i>
								</span>
			</span>
		</button>
	</div>

	<?php if ( $multiple ) : ?>
		<template x-for="value in selected" :key="'input-' + value">
			<input type="hidden" name="<?php echo esc_attr( $input_name ); ?>" :value="value">
		</template>
	<?php else : ?>
		<input type="hidden" name="<?php echo esc_attr( $input_name ); ?>" :value="selected[0] || ''">
	<?php endif; ?>

	<div
		x-show="open"
		x-cloak
		x-transition:enter="transition ease-out duration-150"
		x-transition:enter-start="opacity-0 -translate-y-1"
		x-transition:enter-end="opacity-100 translate-y-0"
		x-transition:leave="transition ease-in duration-100"
		x-transition:leave-start="opacity-100 translate-y-0"
		x-transition:leave-end="opacity-0 -translate-y-1"
		class="mt-2 rounded-[16px] border border-starter-btn-primary-disabled bg-white p-3 shadow-[0_8px_24px_rgba(15,23,42,0.08)] <?php echo esc_attr( $dropdown_class ); ?>"
	>
		<?php if ( $searchable ) : ?>
			<div class="relative mb-3">
				<span class="pointer-events-none absolute inset-y-0 left-3 inline-flex items-center text-starter-icon-subdued">
								<span class="w-3 h-3 flex items-center justify-center">
									<i class="ri-arrow-right-line"></i>
								</span>
				</span>
				<input
					type="text"
					class="h-10 w-full rounded-[12px] border border-starter-btn-primary-disabled bg-white pr-3 pl-9 text-[0.92rem] text-starter-text-black outline-none transition-colors focus:border-[#bfdbfe]"
					placeholder="<?php echo esc_attr( $search_placeholder ); ?>"
					x-model="search"
				>
			</div>
		<?php endif; ?>

		<ul class="max-h-[220px] space-y-1 overflow-y-auto p-0 m-0" role="listbox" <?php echo $multiple ? 'aria-multiselectable="true"' : ''; ?>>
			<li x-show="loading" class="flex min-h-[160px] items-center justify-center" x-cloak>
				<?php set_query_var( 'size', 'sm' ); ?>
				<?php get_template_part( 'template-parts/loading-spinner' ); ?>
				<?php set_query_var( 'size', null ); ?>
			</li>
			<li x-show="!loading && search && filteredOptions.length === 0" class="flex min-h-[120px] items-center justify-center" x-cloak>
				<span class="text-[0.95rem] text-starter-icon-subdued">ไม่พบข้อมูล</span>
			</li>
			<template x-for="option in filteredOptions" :key="option.value">
				<li x-show="!loading">
					<button
						type="button"
						class="flex w-full items-center justify-between rounded-[10px] px-3 py-2 text-left text-[0.95rem] font-medium text-starter-text-black transition-colors"
						:class="isSelected(option.value) ? 'bg-[#dbeafe] text-[#0f67d3]' : 'hover:bg-[#f8fafc]'"
						@click="toggleOption(option.value)"
					>
						<span x-text="option.label"></span>
								<template x-if="isSelected(option.value)">
									<span class="w-3 h-3 flex items-center justify-center">
										<i class="ri-arrow-right-line"></i>
									</span>
								</template>
					</button>
				</li>
			</template>
		</ul>
	</div>
</div>
