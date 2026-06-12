/**
 * Starter Theme Options — React Admin Pages
 *
 * Entry point compiled by @wordpress/scripts (wp-scripts build).
 * Each page mounts into a dedicated DOM root:
 *   #starter-footer-settings-root  → StarterFooterSettings
 *
 * @package starter-theme
 */

import { createRoot, useState, useEffect, useMemo } from '@wordpress/element';
import {
	TabPanel,
	SelectControl,
	RadioControl,
	ToggleControl,
	TextControl,
	TextareaControl,
	Button,
	Spinner,
	Notice,
	Flex,
	FlexItem,
	Card,
	CardBody,
	ColorPicker,
	BaseControl,
	Popover,
	ComboboxControl,
} from '@wordpress/components';
import apiFetch from '@wordpress/api-fetch';
import { __ } from '@wordpress/i18n';

/* ─── Middleware setup ────────────────────────────────────
   WordPress does not always inject nonce middleware on
   generic admin pages. Configure it explicitly using the
   nonce from our wp_localize_script() call.
   ────────────────────────────────────────────────────── */
const _opts = window.StarterThemeOptions || {};
if ( _opts.nonce ) {
	apiFetch.use( apiFetch.createNonceMiddleware( _opts.nonce ) );
}
if ( _opts.restRoot ) {
	apiFetch.use( apiFetch.createRootURLMiddleware( _opts.restRoot ) );
}

/* ============================================================
   Shared: API fetch helpers
   ============================================================ */
function useThemeOptions() {
	const [ options, setOptions ] = useState( {} );
	const [ menus, setMenus ]     = useState( [] );
	const [ loading, setLoading ] = useState( true );
	const [ saving, setSaving ]   = useState( false );
	const [ saved, setSaved ]     = useState( false );
	const [ error, setError ]     = useState( null );

	useEffect( () => {
		var optionsReq = apiFetch( { path: '/starter_theme/v1/options' } )
			.then( function( opts ) {
				setOptions( ( opts && !Array.isArray( opts ) ) ? opts : {} );
			} )
			.catch( function( err ) {
				setError( ( err && err.message ) || ( err && err.code ) || 'Failed to load settings.' );
			} );

		var menusReq = apiFetch( { path: '/starter_theme/v1/menus' } )
			.then( function( menuList ) {
				setMenus( menuList || [] );
			} )
			.catch( function( err ) {
				// eslint-disable-next-line no-console
				console.error( '[Starter Footer] Menus API Error:', err );
			} );

		Promise.all( [ optionsReq, menusReq ] ).then( function() {
			setLoading( false );
		} );
	}, [] );

	const set = ( key, value ) =>
		setOptions( ( prev ) => Object.assign( {}, prev, { [ key ]: value } ) );

	const save = () => {
		setSaving( true );
		setSaved( false );
		apiFetch( {
			path:   '/starter_theme/v1/options',
			method: 'POST',
			data:   options,
		} )
			.then( () => {
				setSaving( false );
				setSaved( true );
				setTimeout( () => setSaved( false ), 3000 );
			} )
			.catch( ( err ) => {
				setError( ( err && err.message ) || 'Save failed.' );
				setSaving( false );
			} );
	};

	return { options, menus, loading, saving, saved, error, set, save };
}

/* ============================================================
   Shared: Components
   ============================================================ */
function CompactColorPicker( { label, color, onChange } ) {
	const [ isOpen, setIsOpen ] = useState( false );
	const pickerId = useMemo( () => Math.random().toString( 36 ).substr( 2, 9 ), [] );

	const toggleOpen = () => {
		const nextOpen = ! isOpen;
		setIsOpen( nextOpen );
		if ( nextOpen ) {
			const event = new CustomEvent( 'starter-color-picker-opened', { detail: { id: pickerId } } );
			window.dispatchEvent( event );
		}
	};

	useEffect( () => {
		const handleOtherOpened = ( e ) => {
			if ( e.detail && e.detail.id !== pickerId ) {
				setIsOpen( false );
			}
		};
		window.addEventListener( 'starter-color-picker-opened', handleOtherOpened );
		return () => {
			window.removeEventListener( 'starter-color-picker-opened', handleOtherOpened );
		};
	}, [ pickerId ] );

	const handleColorChange = ( val ) => {
		if ( typeof val === 'string' ) {
			onChange( val );
		} else if ( val && val.hex ) {
			onChange( val.hex );
		}
	};

	return (
		<BaseControl label={ label } style={ { marginBottom: '1rem' } }>
			<div style={ { display: 'flex', alignItems: 'center', gap: '0.75rem' } }>
				<div style={ { position: 'relative' } }>
					<div
						onClick={ toggleOpen }
						style={ {
							width: '32px',
							height: '32px',
							borderRadius: '6px',
							backgroundColor: color || '#000000',
							border: '2px solid #fff',
							boxShadow: '0 0 0 1px #dcdcde',
							cursor: 'pointer',
						} }
					/>
					{ isOpen && (
						<Popover
							onClose={ () => setIsOpen( false ) }
							position="bottom right"
							noArrow={ false }
							style={ { zIndex: 100000 } }
						>
							<div style={ { padding: '12px' } }>
								<ColorPicker
									color={ color }
									onChange={ handleColorChange }
									onChangeComplete={ handleColorChange }
									enableAlpha={ false }
								/>
							</div>
						</Popover>
					) }
				</div>
				<input
					type="text"
					value={ color || '' }
					onChange={ ( e ) => onChange( e.target.value ) }
					placeholder="#000000"
					style={ {
						padding: '0.4rem 0.6rem',
						border: '1px solid #dcdcde',
						borderRadius: '4px',
						width: '100px',
						fontSize: '13px',
						fontFamily: 'monospace',
					} }
				/>
			</div>
		</BaseControl>
	);
}

/**
 * WPEditor — A wrapper for the classic wp_editor (TinyMCE) in React.
 */
function WPEditor( { label, value, onChange, fieldKey, help } ) {
	const editorId = `tae-editor-${ fieldKey }`.replace( /_/g, '-' );

	useEffect( () => {
		const initEditor = () => {
			if ( window.wp && window.wp.editor ) {
				// Clean up any existing instance first
				if ( window.tinymce && window.tinymce.get( editorId ) ) {
					window.wp.editor.remove( editorId );
				}

				window.wp.editor.initialize( editorId, {
					tinymce: {
						wpautop: true,
						setup: ( ed ) => {
							ed.on( 'change keyup blur', () => {
								const content = ed.getContent();
								onChange( content );
							} );
						},
					},
					quicktags: true,
				} );
			}
		};

		// Small delay to ensure the textarea is in the DOM
		const timer = setTimeout( initEditor, 100 );

		return () => {
			clearTimeout( timer );
			if ( window.wp && window.wp.editor ) {
				window.wp.editor.remove( editorId );
			}
		};
	}, [ fieldKey ] );

	return (
		<BaseControl label={ label } help={ help }>
			<div className="tae-wp-editor-container" style={ { border: '1px solid #dcdcde', borderRadius: '4px', overflow: 'hidden' } }>
				<textarea
					id={ editorId }
					defaultValue={ value }
					rows="8"
					style={ { width: '100%' } }
				/>
			</div>
		</BaseControl>
	);
}


var fieldRow = {
	marginBottom: '1.25rem',
};

var sectionLabel = {
	display: 'block',
	fontWeight: 600,
	fontSize: '0.8125rem',
	textTransform: 'uppercase',
	letterSpacing: '0.04em',
	color: '#50575e',
	marginBottom: '0.875rem',
	paddingBottom: '0.5rem',
	borderBottom: '1px solid #dcdcde',
};

var socialGroup = {
	display: 'grid',
	gridTemplateColumns: '1fr 1fr',
	gap: '0 1.25rem',
};

/* ============================================================
   Component: Phones Repeater
   ============================================================ */
function PhonesRepeater( { value, onChange } ) {
	const phones = Array.isArray( value )
		? value
		: ( typeof value === 'string' && value.trim() !== ''
			? value.split( ',' ).map( ( p ) => p.trim() ).filter( Boolean )
			: [] );

	const addPhone = () => {
		const newPhones = [ ...phones, '' ];
		onChange( newPhones );
	};

	const updatePhone = ( index, val ) => {
		const newPhones = [ ...phones ];
		newPhones[ index ] = val;
		onChange( newPhones );
	};

	const removePhone = ( index ) => {
		const newPhones = phones.filter( ( _, i ) => i !== index );
		onChange( newPhones );
	};

	return (
		<BaseControl label={ __( 'เบอร์โทรศัพท์สำหรับสาขานี้', 'starter-theme' ) } style={ { marginBottom: 0 } }>
			{ phones.length === 0 ? (
				<div style={ { padding: '1rem', background: '#f6f7f7', borderRadius: '6px', border: '1px dashed #c3c4c7', marginBottom: '0.75rem' } }>
					<span style={ { color: '#50575e', fontSize: '13px', display: 'block', marginBottom: '0.5rem' } }>
						{ __( 'ยังไม่มีเบอร์โทรศัพท์สำหรับสาขานี้', 'starter-theme' ) }
					</span>
					<Button variant="secondary" isSmall onClick={ addPhone }>
						{ __( 'เพิ่มเบอร์โทรศัพท์แรก', 'starter-theme' ) }
					</Button>
				</div>
			) : (
				<div>
					{ phones.map( ( phone, index ) => (
						<div key={ index } style={ { display: 'flex', alignItems: 'center', gap: '0.5rem', marginBottom: '0.5rem' } }>
							<TextControl
								value={ phone }
								placeholder={ __( 'เช่น 092-886-9926', 'starter-theme' ) }
								onChange={ ( val ) => updatePhone( index, val ) }
								style={ { marginBottom: 0, flex: 1 } }
							/>
							<Button
								variant="link"
								isDestructive
								isSmall
								onClick={ () => removePhone( index ) }
								style={ { height: '30px', alignSelf: 'center' } }
							>
								{ __( 'ลบ', 'starter-theme' ) }
							</Button>
						</div>
					) ) }
					<Button variant="secondary" isSmall onClick={ addPhone } style={ { marginTop: '0.25rem' } }>
						{ __( '＋ เพิ่มเบอร์โทร', 'starter-theme' ) }
					</Button>
				</div>
			) }
		</BaseControl>
	);
}

/* ============================================================
   Component: Branches Repeater
   ============================================================ */
function BranchesRepeater( { value, onChange } ) {
	const branches = Array.isArray( value ) ? value : [];

	const addBranch = () => {
		const newBranches = [
			...branches,
			{
				title: 'สาขา ' + ( branches.length + 1 ),
				label: 'สาขา ' + ( branches.length + 1 ) + ' :',
				color: '#7a22cb',
				phones: [],
			},
		];
		onChange( newBranches );
	};

	const updateBranch = ( index, key, val ) => {
		const newBranches = [ ...branches ];
		newBranches[ index ] = Object.assign( {}, newBranches[ index ], { [ key ]: val } );
		onChange( newBranches );
	};

	const removeBranch = ( index ) => {
		const newBranches = branches.filter( ( _, i ) => i !== index );
		onChange( newBranches );
	};

	const moveBranch = ( index, direction ) => {
		if ( direction === 'up' && index === 0 ) return;
		if ( direction === 'down' && index === branches.length - 1 ) return;

		const targetIndex = direction === 'up' ? index - 1 : index + 1;
		const newBranches = [ ...branches ];
		const temp = newBranches[ index ];
		newBranches[ index ] = newBranches[ targetIndex ];
		newBranches[ targetIndex ] = temp;
		onChange( newBranches );
	};

	return (
		<div>
			{ branches.length === 0 ? (
				<div style={ { padding: '2rem', textAlign: 'center', background: '#f6f7f7', borderRadius: '8px', border: '1px dashed #c3c4c7', marginBottom: '1.5rem' } }>
					<p style={ { margin: '0 0 1rem 0', color: '#50575e' } }>{ __( 'ยังไม่มีการเพิ่มสาขา', 'starter-theme' ) }</p>
					<Button variant="secondary" onClick={ addBranch }>
						{ __( 'เพิ่มสาขาแรก', 'starter-theme' ) }
					</Button>
				</div>
			) : (
				<div>
					{ branches.map( ( branch, index ) => (
						<Card key={ index } style={ { marginBottom: '1.25rem', border: '1px solid #dcdcde', borderRadius: '8px', boxShadow: 'none' } }>
							<CardBody style={ { padding: '1.25rem' } }>
								<Flex align="center" justify="space-between" style={ { marginBottom: '1rem', borderBottom: '1px solid #f0f0f1', paddingBottom: '0.75rem' } }>
									<FlexItem>
										<strong style={ { fontSize: '14px', color: '#1d2327' } }>
											{ branch.title || `สาขาที่ ${ index + 1 }` }
										</strong>
									</FlexItem>
									<FlexItem>
										<Flex gap={ 1 }>
											<Button
												variant="secondary"
												isSmall
												onClick={ () => moveBranch( index, 'up' ) }
												disabled={ index === 0 }
												style={ { minWidth: 'auto', padding: '0 8px' } }
											>
												▲
											</Button>
											<Button
												variant="secondary"
												isSmall
												onClick={ () => moveBranch( index, 'down' ) }
												disabled={ index === branches.length - 1 }
												style={ { minWidth: 'auto', padding: '0 8px' } }
											>
												▼
											</Button>
											<Button
												variant="link"
												isDestructive
												isSmall
												onClick={ () => removeBranch( index ) }
											>
												{ __( 'ลบสาขา', 'starter-theme' ) }
											</Button>
										</Flex>
									</FlexItem>
								</Flex>

								<div style={ socialGroup }>
									<div style={ { marginBottom: '1rem' } }>
										<TextControl
											label={ __( 'ชื่อปุ่มสาขา (แสดงใน Header)', 'starter-theme' ) }
											value={ branch.title || '' }
											placeholder="เช่น สาขา 1"
											onChange={ ( val ) => updateBranch( index, 'title', val ) }
										/>
									</div>
									<div style={ { marginBottom: '1rem' } }>
										<TextControl
											label={ __( 'ข้อความแสดงสาขา (แสดงใน Popup)', 'starter-theme' ) }
											value={ branch.label || '' }
											placeholder="เช่น สาขา 1 :"
											onChange={ ( val ) => updateBranch( index, 'label', val ) }
										/>
									</div>
								</div>

								<div style={ { display: 'grid', gridTemplateColumns: '130px 1fr', gap: '0 1.25rem' } }>
									<div style={ { marginBottom: '1rem' } }>
										<CompactColorPicker
											label={ __( 'สีของปุ่มเบอร์โทร', 'starter-theme' ) }
											color={ branch.color || '#7a22cb' }
											onChange={ ( val ) => updateBranch( index, 'color', val ) }
										/>
									</div>
									<div style={ { marginBottom: '1rem' } }>
										<PhonesRepeater
											value={ branch.phones }
											onChange={ ( val ) => updateBranch( index, 'phones', val ) }
										/>
									</div>
								</div>
							</CardBody>
						</Card>
					) ) }

					<Button variant="secondary" onClick={ addBranch } style={ { marginBottom: '1.5rem' } }>
						{ __( '＋ เพิ่มสาขาใหม่', 'starter-theme' ) }
					</Button>
				</div>
			) }
		</div>
	);
}

/* ============================================================
   Page: Header Settings
   ============================================================ */
function HeaderSettings() {
	const { options, loading, saving, saved, error, set, save } =
		useThemeOptions();

	if ( loading ) {
		return (
			<div style={ { margin: '2rem', display: 'flex', alignItems: 'center', gap: '0.75rem' } }>
				<Spinner />
				<span style={ { color: '#50575e' } }>{ __( 'Loading settings…', 'starter-theme' ) }</span>
			</div>
		);
	}

	return (
		<div style={ { maxWidth: '860px' } }>

			{ /* ── Sticky top bar ── */ }
			<div style={ {
				position: 'sticky',
				top: '32px',
				zIndex: 99,
				background: '#f0f0f1',
				padding: '0.875rem 1.5rem',
				marginBottom: '1.5rem',
				borderRadius: '4px',
				border: '1px solid #dcdcde',
				display: 'flex',
				alignItems: 'center',
				justifyContent: 'space-between',
				gap: '1rem',
			} }>
				<h1 style={ { margin: 0, fontSize: '1rem', fontWeight: 600, color: '#1d2327', whiteSpace: 'nowrap', flexShrink: 0 } }>
					{ __( 'Header Settings', 'starter-theme' ) }
				</h1>
				<Flex align="center" gap={ 3 }>
					{ saved && (
						<FlexItem>
							<span style={ { color: '#00a32a', fontWeight: 500, fontSize: '0.875rem', display: 'flex', alignItems: 'center', gap: '0.375rem' } }>
								<span style={ { fontSize: '1rem' } }>✓</span>
								{ __( 'Saved', 'starter-theme' ) }
							</span>
						</FlexItem>
					) }
					<FlexItem>
						<Button
							variant="primary"
							onClick={ save }
							isBusy={ saving }
							disabled={ saving }
							style={ { minWidth: '120px' } }
						>
							{ saving ? __( 'Saving…', 'starter-theme' ) : __( 'Save Settings', 'starter-theme' ) }
						</Button>
					</FlexItem>
				</Flex>
			</div>

			{ error && (
				<Notice status="error" isDismissible onDismiss={ () => {} } style={ { marginBottom: '1rem' } }>
					{ error }
				</Notice>
			) }

			{ /* ── Tabs ── */ }
			<TabPanel
				tabs={ [
					{ name: 'layout', title: <span><i className="ri-layout-line"></i> รูปแบบ</span> },
					{ name: 'colors', title: <span><i className="ri-palette-line"></i> สี</span> },
					{ name: 'branches', title: <span><i className="ri-map-pin-line"></i> สาขา</span> },
				] }
			>
				{ ( tab ) => (
					<Card style={ { marginTop: '0', borderTop: 'none', borderRadius: '0 4px 4px 4px' } }>
						<CardBody style={ { padding: '1.75rem 2rem' } }>

							{ /* ────────── TAB: Branches ────────── */ }
							{ tab.name === 'branches' && (
								<div>
									<span style={ sectionLabel }>{ __( 'ตั้งค่าข้อมูลสาขา (เบอร์โทรศัพท์ Pills)', 'starter-theme' ) }</span>
									<BranchesRepeater
										value={ options.header_branches }
										onChange={ ( val ) => set( 'header_branches', val ) }
									/>
								</div>
							) }

							{ /* ────────── TAB: Layout ────────── */ }
							{ tab.name === 'layout' && (
								<div>
									<span style={ sectionLabel }>{ __( 'ตั้งค่ารูปแบบ Header', 'starter-theme' ) }</span>
									<div style={ fieldRow }>
										<SelectControl
											label={ __( 'Header Style', 'starter-theme' ) }
											value={ options.header_style || 'default' }
											options={ [
												{ label: __( 'Default — Multi-row with scrolled variant', 'starter-theme' ), value: 'default' },
												{ label: __( 'Simple — Single row', 'starter-theme' ), value: 'simple' },
												{ label: __( 'Woodmart — Single row with centered desktop logo', 'starter-theme' ), value: 'woodmart' },
											] }
											onChange={ ( val ) => set( 'header_style', val ) }
											help={ __( 'Select the overall header layout.', 'starter-theme' ) }
										/>
									</div>
									<div style={ fieldRow }>
										<SelectControl
											label={ __( 'Desktop Menu Style', 'starter-theme' ) }
											value={ options.desktop_menu_style || 'mega' }
											options={ [
												{ label: __( 'Mega Menu (image + grid variants)', 'starter-theme' ), value: 'mega' },
												{ label: __( 'Standard Dropdown', 'starter-theme' ), value: 'standard' },
												{ label: __( 'Woodmart Dropdown', 'starter-theme' ), value: 'woodmart' },
											] }
											onChange={ ( val ) => set( 'desktop_menu_style', val ) }
											help={ __( 'Select how desktop sub-menus are rendered.', 'starter-theme' ) }
										/>
									</div>
									<div style={ fieldRow }>
										<SelectControl
											label={ __( 'Header Position', 'starter-theme' ) }
											value={ options.header_position || 'relative' }
											options={ [
												{ label: __( 'Relative (scrolls with page)', 'starter-theme' ), value: 'relative' },
												{ label: __( 'Sticky (fixed when scrolling)', 'starter-theme' ), value: 'sticky' },
												{ label: __( 'Fixed (always on top, transparent on homepage)', 'starter-theme' ), value: 'fixed' },
											] }
											onChange={ ( val ) => set( 'header_position', val ) }
											help={ __( 'Select how the header behaves on scroll.', 'starter-theme' ) }
										/>
									</div>
									<div style={ fieldRow }>
										<RadioControl
											label={ __( 'Sticky Disable On', 'starter-theme' ) }
											selected={ options.sub_sticky_disable_on || 'none' }
											options={ [
												{ label: __( 'None', 'starter-theme' ), value: 'none' },
												{ label: __( 'Mobile Only', 'starter-theme' ), value: 'mobile' },
												{ label: __( 'Tablet Only', 'starter-theme' ), value: 'tablet' },
												{ label: __( 'Mobile + Tablet', 'starter-theme' ), value: 'mobile_tablet' },
											] }
											onChange={ ( val ) => set( 'sub_sticky_disable_on', val ) }
											help={ __( 'Controls when the Starter sticky/sub-sticky behavior is disabled.', 'starter-theme' ) }
										/>
									</div>
									<div style={ fieldRow }>
										<ToggleControl
											label={ __( 'Dark Mode', 'starter-theme' ) }
											checked={ options.enable_dark_mode === '1' }
											onChange={ ( val ) => set( 'enable_dark_mode', val ? '1' : '0' ) }
											help={ __( 'Enable or disable dark mode toggle in the header.', 'starter-theme' ) }
										/>
									</div>
									<div style={ fieldRow }>
										<ToggleControl
											label={ __( 'Show Sign In Button', 'starter-theme' ) }
											checked={ options.woodmart_show_login_button !== '0' }
											onChange={ ( val ) => set( 'woodmart_show_login_button', val ? '1' : '0' ) }
											help={ __( 'Show or hide the Sign In button in the Woodmart header layout.', 'starter-theme' ) }
										/>
									</div>
									<div style={ fieldRow }>
										<ToggleControl
											label={ __( 'Show Quick Action Buttons', 'starter-theme' ) }
											checked={ options.woodmart_show_quick_actions !== '0' }
											onChange={ ( val ) => set( 'woodmart_show_quick_actions', val ? '1' : '0' ) }
											help={ __( 'Show or hide the quick action pills in the Woodmart header.', 'starter-theme' ) }
										/>
									</div>
									<div style={ fieldRow }>
										<ToggleControl
											label={ __( 'Show Hotline Button', 'starter-theme' ) }
											checked={ options.woodmart_show_hotline_button !== '0' }
											onChange={ ( val ) => set( 'woodmart_show_hotline_button', val ? '1' : '0' ) }
											help={ __( 'Show or hide the hotline pill in the Woodmart header.', 'starter-theme' ) }
										/>
									</div>
									<div style={ fieldRow }>
										<ToggleControl
											label={ __( 'Show Search Button', 'starter-theme' ) }
											checked={ options.woodmart_show_search_button !== '0' }
											onChange={ ( val ) => set( 'woodmart_show_search_button', val ? '1' : '0' ) }
											help={ __( 'Show or hide the search button in the Woodmart header.', 'starter-theme' ) }
										/>
									</div>
									<div style={ fieldRow }>
										<ToggleControl
											label={ __( 'Show Cart Button', 'starter-theme' ) }
											checked={ options.woodmart_show_cart_button !== '0' }
											onChange={ ( val ) => set( 'woodmart_show_cart_button', val ? '1' : '0' ) }
											help={ __( 'Show or hide the cart button in the Woodmart header.', 'starter-theme' ) }
										/>
									</div>
								</div>
							) }

							{ /* ────────── TAB: Colors ────────── */ }
							{ tab.name === 'colors' && (
								<div>
									<span style={ sectionLabel }>{ __( 'ตั้งค่าสี Header', 'starter-theme' ) }</span>
									<div style={ socialGroup }>
										<CompactColorPicker 
											label={ __( 'สีพื้นหลัง Header', 'starter-theme' ) }
											color={ options.header_bg_color || '#ffffff' }
											onChange={ ( hex ) => set( 'header_bg_color', hex ) }
										/>
										<CompactColorPicker 
											label={ __( 'สีตัวอักษร Header', 'starter-theme' ) }
											color={ options.header_text_color || '#1d2327' }
											onChange={ ( hex ) => set( 'header_text_color', hex ) }
										/>
									</div>

									<span style={ Object.assign( {}, sectionLabel, { marginTop: '1.5rem' } ) }>{ __( 'ตั้งค่าสี Header ขณะเลื่อนหน้าจอ (Scrolling)', 'starter-theme' ) }</span>
									<div style={ socialGroup }>
										<CompactColorPicker 
											label={ __( 'สีพื้นหลัง Header (เลื่อน)', 'starter-theme' ) }
											color={ options.header_scroll_bg_color || '#ffffff' }
											onChange={ ( hex ) => set( 'header_scroll_bg_color', hex ) }
										/>
										<CompactColorPicker 
											label={ __( 'สีตัวอักษร Header (เลื่อน)', 'starter-theme' ) }
											color={ options.header_scroll_text_color || '#1d2327' }
											onChange={ ( hex ) => set( 'header_scroll_text_color', hex ) }
										/>
									</div>

									<span style={ Object.assign( {}, sectionLabel, { marginTop: '1.5rem' } ) }>{ __( 'ตั้งค่าสี Dropdown เมนู', 'starter-theme' ) }</span>
									<div style={ socialGroup }>
										<CompactColorPicker 
											label={ __( 'สีพื้นหลัง Dropdown', 'starter-theme' ) }
											color={ options.header_dropdown_bg_color || '#ffffff' }
											onChange={ ( hex ) => set( 'header_dropdown_bg_color', hex ) }
										/>
										<CompactColorPicker 
											label={ __( 'สีตัวอักษร Dropdown', 'starter-theme' ) }
											color={ options.header_dropdown_text_color || '#1d2327' }
											onChange={ ( hex ) => set( 'header_dropdown_text_color', hex ) }
										/>
									</div>

									<span style={ Object.assign( {}, sectionLabel, { marginTop: '1.5rem' } ) }>{ __( 'ตั้งค่าสีกล่อง Popup (เช่น สาขา)', 'starter-theme' ) }</span>
									<div style={ socialGroup }>
										<CompactColorPicker 
											label={ __( 'สีพื้นหลัง Popup', 'starter-theme' ) }
											color={ options.header_popup_bg_color || '#ffffff' }
											onChange={ ( hex ) => set( 'header_popup_bg_color', hex ) }
										/>
										<CompactColorPicker 
											label={ __( 'สีตัวอักษร Popup', 'starter-theme' ) }
											color={ options.header_popup_text_color || '#1d2327' }
											onChange={ ( hex ) => set( 'header_popup_text_color', hex ) }
										/>
									</div>

									<span style={ Object.assign( {}, sectionLabel, { marginTop: '1.5rem' } ) }>{ __( 'ตั้งค่าสีปุ่มต่างๆ ใน Header', 'starter-theme' ) }</span>
									
									<div style={ { marginBottom: '1.5rem' } }>
										<h4 style={ { fontSize: '13px', fontWeight: '600', marginBottom: '10px' } }>{ __( 'ปุ่มเมนู (Toggle)', 'starter-theme' ) }</h4>
										<div style={ socialGroup }>
											<CompactColorPicker 
												label={ __( 'สีพื้นหลัง', 'starter-theme' ) }
												color={ options.mobile_toggle_bg_color || 'transparent' }
												onChange={ ( hex ) => set( 'mobile_toggle_bg_color', hex ) }
											/>
											<CompactColorPicker 
												label={ __( 'สีไอคอน', 'starter-theme' ) }
												color={ options.mobile_toggle_text_color || '#111827' }
												onChange={ ( hex ) => set( 'mobile_toggle_text_color', hex ) }
											/>
										</div>
									</div>

									<div style={ { marginBottom: '1.5rem' } }>
										<h4 style={ { fontSize: '13px', fontWeight: '600', marginBottom: '10px' } }>{ __( 'ปุ่มค้นหา (Search)', 'starter-theme' ) }</h4>
										<div style={ socialGroup }>
											<CompactColorPicker 
												label={ __( 'สีพื้นหลัง', 'starter-theme' ) }
												color={ options.header_search_bg_color || 'transparent' }
												onChange={ ( hex ) => set( 'header_search_bg_color', hex ) }
											/>
											<CompactColorPicker 
												label={ __( 'สีไอคอน', 'starter-theme' ) }
												color={ options.header_search_color || '#111827' }
												onChange={ ( hex ) => set( 'header_search_color', hex ) }
											/>
										</div>
									</div>

									<div style={ { marginBottom: '1.5rem' } }>
										<h4 style={ { fontSize: '13px', fontWeight: '600', marginBottom: '10px' } }>{ __( 'ปุ่มเปลี่ยนโหมด (Dark Mode)', 'starter-theme' ) }</h4>
										<div style={ socialGroup }>
											<CompactColorPicker 
												label={ __( 'สีพื้นหลัง', 'starter-theme' ) }
												color={ options.header_dark_mode_bg_color || 'transparent' }
												onChange={ ( hex ) => set( 'header_dark_mode_bg_color', hex ) }
											/>
											<CompactColorPicker 
												label={ __( 'สีไอคอน', 'starter-theme' ) }
												color={ options.header_dark_mode_color || '#111827' }
												onChange={ ( hex ) => set( 'header_dark_mode_color', hex ) }
											/>
										</div>
									</div>

									<div style={ { marginBottom: '1.5rem' } }>
										<h4 style={ { fontSize: '13px', fontWeight: '600', marginBottom: '10px' } }>{ __( 'ปุ่มรถเข็น (Cart)', 'starter-theme' ) }</h4>
										<div style={ socialGroup }>
											<CompactColorPicker 
												label={ __( 'สีพื้นหลัง', 'starter-theme' ) }
												color={ options.header_cart_bg_color || 'transparent' }
												onChange={ ( hex ) => set( 'header_cart_bg_color', hex ) }
											/>
											<CompactColorPicker 
												label={ __( 'สีไอคอน', 'starter-theme' ) }
												color={ options.header_cart_color || '#111827' }
												onChange={ ( hex ) => set( 'header_cart_color', hex ) }
											/>
										</div>
									</div>

									<span style={ Object.assign( {}, sectionLabel, { marginTop: '1.5rem' } ) }>{ __( 'ตั้งค่าสีตัวเปลี่ยนภาษา (Language Switcher)', 'starter-theme' ) }</span>
									<div style={ socialGroup }>
										<CompactColorPicker 
											label={ __( 'สีตัวอักษรภาษา', 'starter-theme' ) }
											color={ options.language_switcher_color || '#1d2327' }
											onChange={ ( hex ) => set( 'language_switcher_color', hex ) }
										/>
									</div>

									<span style={ Object.assign( {}, sectionLabel, { marginTop: '1.5rem' } ) }>{ __( 'ตั้งค่าสีลิงก์', 'starter-theme' ) }</span>
									<div style={ socialGroup }>
										<CompactColorPicker 
											label={ __( 'สีลิงก์', 'starter-theme' ) }
											color={ options.link_color || '#EC008C' }
											onChange={ ( hex ) => set( 'link_color', hex ) }
										/>
										<CompactColorPicker 
											label={ __( 'สีลิงก์ (Hover)', 'starter-theme' ) }
											color={ options.link_hover_color || '#8E2BAF' }
											onChange={ ( hex ) => set( 'link_hover_color', hex ) }
										/>
									</div>

									<span style={ Object.assign( {}, sectionLabel, { marginTop: '1.5rem' } ) }>{ __( 'ตั้งค่าสีปุ่มนัดหมาย (CTA)', 'starter-theme' ) }</span>
									<div style={ socialGroup }>
										<CompactColorPicker 
											label={ __( 'สีพื้นหลังปุ่ม', 'starter-theme' ) }
											color={ options.login_button_bg_color || '#EC008C' }
											onChange={ ( hex ) => set( 'login_button_bg_color', hex ) }
										/>
										<CompactColorPicker 
											label={ __( 'สีตัวอักษรปุ่ม', 'starter-theme' ) }
											color={ options.login_button_text_color || '#ffffff' }
											onChange={ ( hex ) => set( 'login_button_text_color', hex ) }
										/>
										<CompactColorPicker 
											label={ __( 'สีพื้นหลัง (Hover)', 'starter-theme' ) }
											color={ options.login_button_bg_hover_color || '#C40072' }
											onChange={ ( hex ) => set( 'login_button_bg_hover_color', hex ) }
										/>
										<CompactColorPicker 
											label={ __( 'สีตัวอักษร (Hover)', 'starter-theme' ) }
											color={ options.login_button_text_hover_color || '#ffffff' }
											onChange={ ( hex ) => set( 'login_button_text_hover_color', hex ) }
										/>
									</div>

									<span style={ Object.assign( {}, sectionLabel, { marginTop: '1.5rem' } ) }>{ __( 'ตั้งค่าสีปุ่มสาขา (Branches)', 'starter-theme' ) }</span>
									<div style={ socialGroup }>
										<CompactColorPicker 
											label={ __( 'สีพื้นหลังปุ่ม', 'starter-theme' ) }
											color={ options.header_branch_bg_color || '#ffffff' }
											onChange={ ( hex ) => set( 'header_branch_bg_color', hex ) }
										/>
										<CompactColorPicker 
											label={ __( 'สีตัวอักษรและไอคอน', 'starter-theme' ) }
											color={ options.header_branch_color || '#1d2327' }
											onChange={ ( hex ) => set( 'header_branch_color', hex ) }
										/>
										<CompactColorPicker 
											label={ __( 'สีขอบปุ่ม', 'starter-theme' ) }
											color={ options.header_branch_border_color || '#e5e7eb' }
											onChange={ ( hex ) => set( 'header_branch_border_color', hex ) }
										/>
										<CompactColorPicker 
											label={ __( 'สีพื้นหลังปุ่ม (เมื่อกดเปิด)', 'starter-theme' ) }
											color={ options.header_branch_active_bg_color || '#ec008c' }
											onChange={ ( hex ) => set( 'header_branch_active_bg_color', hex ) }
										/>
										<CompactColorPicker
											label={ __( 'สีตัวอักษรและไอคอน (เมื่อกดเปิด)', 'starter-theme' ) }
											color={ options.header_branch_active_color || '#ffffff' }
											onChange={ ( hex ) => set( 'header_branch_active_color', hex ) }
										/>
									</div>

									<span style={ Object.assign( {}, sectionLabel, { marginTop: '1.5rem' } ) }>{ __( 'ตั้งค่าสีไอคอนโทรศัพท์ในเมนู', 'starter-theme' ) }</span>
									<div style={ socialGroup }>
										<CompactColorPicker
											label={ __( 'สีพื้นหลังไอคอนโทรศัพท์', 'starter-theme' ) }
											color={ options.header_branch_phone_bg || '#fde3f1' }
											onChange={ ( hex ) => set( 'header_branch_phone_bg', hex ) }
										/>
										<CompactColorPicker
											label={ __( 'สีไอคอนโทรศัพท์', 'starter-theme' ) }
											color={ options.header_branch_phone_color || '#ec008c' }
											onChange={ ( hex ) => set( 'header_branch_phone_color', hex ) }
										/>
									</div>

									<span style={ Object.assign( {}, sectionLabel, { marginTop: '1.5rem' } ) }>{ __( 'ตั้งค่าสีเมนูมือถือ', 'starter-theme' ) }</span>
									<div style={ socialGroup }>
										<CompactColorPicker 
											label={ __( 'สีพื้นหลังเมนู', 'starter-theme' ) }
											color={ options.mobile_menu_bg_color || '#ffffff' }
											onChange={ ( hex ) => set( 'mobile_menu_bg_color', hex ) }
										/>
										<CompactColorPicker 
											label={ __( 'สีตัวอักษรเมนู', 'starter-theme' ) }
											color={ options.mobile_menu_text_color || '#1d2327' }
											onChange={ ( hex ) => set( 'mobile_menu_text_color', hex ) }
										/>
									</div>

									<span style={ Object.assign( {}, sectionLabel, { marginTop: '1.5rem' } ) }>{ __( 'สีเมนูมือถือ Hover / Active', 'starter-theme' ) }</span>
									<div style={ socialGroup }>
										<CompactColorPicker
											label={ __( 'สีพื้นหลัง Hover', 'starter-theme' ) }
											color={ options.mobile_menu_hover_bg || '#fde3f1' }
											onChange={ ( hex ) => set( 'mobile_menu_hover_bg', hex ) }
										/>
										<CompactColorPicker
											label={ __( 'สีตัวอักษร Hover', 'starter-theme' ) }
											color={ options.mobile_menu_hover_text || '#ec008c' }
											onChange={ ( hex ) => set( 'mobile_menu_hover_text', hex ) }
										/>
										<CompactColorPicker
											label={ __( 'สีพื้นหลัง Active', 'starter-theme' ) }
											color={ options.mobile_menu_active_bg || '#fde3f1' }
											onChange={ ( hex ) => set( 'mobile_menu_active_bg', hex ) }
										/>
										<CompactColorPicker
											label={ __( 'สีตัวอักษร Active', 'starter-theme' ) }
											color={ options.mobile_menu_active_text || '#ec008c' }
											onChange={ ( hex ) => set( 'mobile_menu_active_text', hex ) }
										/>
									</div>
								</div>
							) }

						</CardBody>
					</Card>
				) }
			</TabPanel>
		</div>
	);
}

/* ============================================================
   Page: Starter Footer Settings
   ============================================================ */
function StarterFooterSettings() {
	const { options, menus, loading, saving, saved, error, set, save } =
		useThemeOptions();

	if ( loading ) {
		return (
			<div style={ { margin: '2rem', display: 'flex', alignItems: 'center', gap: '0.75rem' } }>
				<Spinner />
				<span style={ { color: '#50575e' } }>{ __( 'Loading settings…', 'starter-theme' ) }</span>
			</div>
		);
	}

	return (
		<div style={ { maxWidth: '860px' } }>

			{ /* ── Sticky top bar ── */ }
			<div style={ {
				position: 'sticky',
				top: '32px',
				zIndex: 99,
				background: '#f0f0f1',
				padding: '0.875rem 1.5rem',
				marginBottom: '1.5rem',
				borderRadius: '4px',
				border: '1px solid #dcdcde',
				display: 'flex',
				alignItems: 'center',
				justifyContent: 'space-between',
				gap: '1rem',
			} }>
				<h1 style={ { margin: 0, fontSize: '1rem', fontWeight: 600, color: '#1d2327', whiteSpace: 'nowrap', flexShrink: 0 } }>
					{ __( 'Starter Footer Settings', 'starter-theme' ) }
				</h1>
				<Flex align="center" gap={ 3 }>
					{ saved && (
						<FlexItem>
							<span style={ { color: '#00a32a', fontWeight: 500, fontSize: '0.875rem', display: 'flex', alignItems: 'center', gap: '0.375rem' } }>
								<span style={ { fontSize: '1rem' } }>✓</span>
								{ __( 'Saved', 'starter-theme' ) }
							</span>
						</FlexItem>
					) }
					<FlexItem>
						<Button
							variant="primary"
							onClick={ save }
							isBusy={ saving }
							disabled={ saving }
							style={ { minWidth: '120px' } }
						>
							{ saving ? __( 'Saving…', 'starter-theme' ) : __( 'Save Settings', 'starter-theme' ) }
						</Button>
					</FlexItem>
				</Flex>
			</div>

			{ error && (
				<Notice status="error" isDismissible onDismiss={ () => {} } style={ { marginBottom: '1rem' } }>
					{ error }
				</Notice>
			) }

			{ /* ── Tabs ── */ }
			<TabPanel
				tabs={ [
					{ name: 'brand',   title: <span><i className="ri-building-2-line"></i> แบรนด์</span> },
					{ name: 'address', title: <span><i className="ri-map-pin-line"></i> ที่อยู่</span> },
					{ name: 'contact', title: <span><i className="ri-phone-line"></i> ติดต่อเรา</span> },
					{ name: 'social',  title: <span><i className="ri-share-line"></i> โซเชียล</span> },
					{ name: 'bottom',  title: <span><i className="ri-settings-3-line"></i> แถบล่าง</span> },
				] }
			>
				{ ( tab ) => (
					<Card style={ { marginTop: '0', borderTop: 'none', borderRadius: '0 4px 4px 4px' } }>
						<CardBody style={ { padding: '1.75rem 2rem' } }>

							{ /* ────────── TAB: Brand ────────── */ }
							{ tab.name === 'brand' && (
								<div>
									<span style={ sectionLabel }>{ __( 'แบรนด์', 'starter-theme' ) }</span>
									<div style={ fieldRow }>
										<BaseControl label={ __( 'โลโก้ Footer', 'starter-theme' ) } help={ __( 'อัปโหลดรูปภาพโลโก้สำหรับแสดงใน Footer', 'starter-theme' ) }>
											<div style={ { display: 'flex', gap: '10px', alignItems: 'center' } }>
												<Button
													variant="secondary"
													onClick={ () => {
														const frame = window.wp.media({
															title: __( 'เลือกโลโก้ Footer', 'starter-theme' ),
															multiple: false,
															library: { type: 'image' },
															button: { text: __( 'ใช้รูปภาพนี้', 'starter-theme' ) }
														});
														frame.on( 'select', () => {
															const attachment = frame.state().get( 'selection' ).first().toJSON();
															set( 'starter_footer_logo', attachment.url );
														});
														frame.open();
													} }
												>
													{ options.starter_footer_logo ? __( 'เปลี่ยนรูปภาพ', 'starter-theme' ) : __( 'เลือกรูปภาพ', 'starter-theme' ) }
												</Button>
											</div>
											{ options.starter_footer_logo && (
												<div style={ { marginTop: '0.75rem' } }>
													<img src={ options.starter_footer_logo } alt="Preview" style={ { maxWidth: '120px', height: 'auto', display: 'block' } } />
													<Button
														variant="link"
														isDestructive
														onClick={ () => set( 'starter_footer_logo', '' ) }
														style={ { marginTop: '0.5rem', paddingLeft: 0 } }
													>
														{ __( 'ลบรูปภาพ', 'starter-theme' ) }
													</Button>
												</div>
											) }
										</BaseControl>
									</div>
									<div style={ fieldRow }>
										<TextControl
											label={ __( 'ชื่อแบรนด์', 'starter-theme' ) }
											value={ options.starter_footer_brand_title || '' }
											placeholder="SMILE CARE"
											onChange={ ( val ) => set( 'starter_footer_brand_title', val ) }
										/>
									</div>
									<div style={ fieldRow }>
										<TextControl
											label={ __( 'คำบรรยายแบรนด์', 'starter-theme' ) }
											value={ options.starter_footer_brand_subtitle || '' }
											placeholder="Dental Clinic"
											onChange={ ( val ) => set( 'starter_footer_brand_subtitle', val ) }
										/>
									</div>
								</div>
							) }

							{ /* ────────── TAB: Address ────────── */ }
							{ tab.name === 'address' && (
								<div>
									<span style={ sectionLabel }>{ __( 'ข้อมูลที่อยู่', 'starter-theme' ) }</span>
									<div style={ fieldRow }>
										<TextControl
											label={ __( 'ชื่อหัวข้อ', 'starter-theme' ) }
											value={ options.starter_footer_address_title || '' }
											placeholder="ที่อยู่"
											onChange={ ( val ) => set( 'starter_footer_address_title', val ) }
										/>
									</div>
									<div style={ fieldRow }>
										<WPEditor
											label={ __( 'ข้อมูลที่อยู่ (Full Editor)', 'starter-theme' ) }
											fieldKey="starter_footer_address_lines"
											value={ options.starter_footer_address_lines || '' }
											onChange={ ( val ) => set( 'starter_footer_address_lines', val ) }
											help={ __( 'สามารถใส่ข้อความแบบจัดรูปแบบได้', 'starter-theme' ) }
										/>
									</div>
									<span style={ Object.assign( {}, sectionLabel, { marginTop: '1.5rem' } ) }>{ __( 'ลิงก์แผนที่', 'starter-theme' ) }</span>
									<div style={ socialGroup }>
										<div style={ fieldRow }>
											<TextControl
												label={ __( 'ข้อความปุ่ม', 'starter-theme' ) }
												value={ options.starter_footer_map_label || '' }
												placeholder="ดูแผนที่"
												onChange={ ( val ) => set( 'starter_footer_map_label', val ) }
											/>
										</div>
										<div style={ fieldRow }>
											<TextControl
												label={ __( 'URL แผนที่', 'starter-theme' ) }
												value={ options.starter_footer_map_url || '' }
												placeholder="https://maps.google.com/..."
												type="url"
												onChange={ ( val ) => set( 'starter_footer_map_url', val ) }
											/>
										</div>
									</div>
								</div>
							) }

							{ /* ────────── TAB: Contact ────────── */ }
							{ tab.name === 'contact' && (
								<div>
									<span style={ sectionLabel }>{ __( 'ข้อมูลการติดต่อ', 'starter-theme' ) }</span>
									<div style={ fieldRow }>
										<TextControl
											label={ __( 'ชื่อหัวข้อ', 'starter-theme' ) }
											value={ options.starter_footer_contact_title || '' }
											placeholder="ติดต่อเรา"
											onChange={ ( val ) => set( 'starter_footer_contact_title', val ) }
										/>
									</div>
									<div style={ Object.assign( {}, socialGroup, { gridTemplateColumns: '1fr 1fr 1fr' } ) }>
										<div style={ fieldRow }>
											<TextControl
												label={ __( 'Hotline', 'starter-theme' ) }
												value={ options.starter_footer_hotline || '' }
												placeholder="1543"
												onChange={ ( val ) => set( 'starter_footer_hotline', val ) }
											/>
										</div>
										<div style={ fieldRow }>
											<TextControl
												label={ __( 'โทรศัพท์', 'starter-theme' ) }
												value={ options.starter_footer_phone || '' }
												placeholder="0 2558 9800"
												onChange={ ( val ) => set( 'starter_footer_phone', val ) }
											/>
										</div>
										<div style={ fieldRow }>
											<TextControl
												label={ __( 'โทรสาร (Fax)', 'starter-theme' ) }
												value={ options.starter_footer_fax || '' }
												placeholder="0 2558 9788-9"
												onChange={ ( val ) => set( 'starter_footer_fax', val ) }
											/>
										</div>
									</div>
									<div style={ fieldRow }>
										<TextControl
											label={ __( 'อีเมล', 'starter-theme' ) }
											value={ options.starter_footer_email || '' }
											type="email"
											placeholder="saraban@Starter.co.th"
											onChange={ ( val ) => set( 'starter_footer_email', val ) }
										/>
									</div>
								</div>
							) }

							{ /* ────────── TAB: Social ────────── */ }
							{ tab.name === 'social' && (
								<div>
									<div style={ fieldRow }>
										<TextControl
											label={ __( 'ชื่อหัวข้อ', 'starter-theme' ) }
											value={ options.starter_footer_social_title || '' }
											placeholder="ติดตามข่าวสาร"
											onChange={ ( val ) => set( 'starter_footer_social_title', val ) }
										/>
									</div>
									<span style={ Object.assign( {}, sectionLabel, { marginTop: '1rem' } ) }>Facebook</span>
									<div style={ socialGroup }>
										<div style={ fieldRow }>
											<TextControl
												label={ __( 'Label', 'starter-theme' ) }
												value={ options.starter_footer_facebook_label || '' }
												placeholder="/ExpresswayThailand"
												onChange={ ( val ) => set( 'starter_footer_facebook_label', val ) }
											/>
										</div>
										<div style={ fieldRow }>
											<TextControl
												label={ __( 'URL', 'starter-theme' ) }
												value={ options.starter_footer_facebook_url || '' }
												type="url"
												placeholder="https://facebook.com/..."
												onChange={ ( val ) => set( 'starter_footer_facebook_url', val ) }
											/>
										</div>
									</div>
									<span style={ sectionLabel }>X (Twitter)</span>
									<div style={ socialGroup }>
										<div style={ fieldRow }>
											<TextControl
												label={ __( 'Label', 'starter-theme' ) }
												value={ options.starter_footer_x_label || '' }
												placeholder="/StarterWebmaster"
												onChange={ ( val ) => set( 'starter_footer_x_label', val ) }
											/>
										</div>
										<div style={ fieldRow }>
											<TextControl
												label={ __( 'URL', 'starter-theme' ) }
												value={ options.starter_footer_x_url || '' }
												type="url"
												placeholder="https://x.com/..."
												onChange={ ( val ) => set( 'starter_footer_x_url', val ) }
											/>
										</div>
									</div>
									<span style={ sectionLabel }>YouTube</span>
									<div style={ socialGroup }>
										<div style={ fieldRow }>
											<TextControl
												label={ __( 'Label', 'starter-theme' ) }
												value={ options.starter_footer_youtube_label || '' }
												placeholder="@expresswaythailand"
												onChange={ ( val ) => set( 'starter_footer_youtube_label', val ) }
											/>
										</div>
										<div style={ fieldRow }>
											<TextControl
												label={ __( 'URL', 'starter-theme' ) }
												value={ options.starter_footer_youtube_url || '' }
												type="url"
												placeholder="https://youtube.com/@..."
												onChange={ ( val ) => set( 'starter_footer_youtube_url', val ) }
											/>
										</div>
									</div>
								</div>
							) }

							{ /* ────────── TAB: Bottom Bar ────────── */ }
							{ tab.name === 'bottom' && (
								<div>
									<span style={ sectionLabel }>{ __( 'เมนูนำทาง', 'starter-theme' ) }</span>
									<div style={ fieldRow }>
										<SelectControl
											label={ __( 'เมนู Footer', 'starter-theme' ) }
											value={ options.starter_footer_nav_menu || '' }
											options={ menus }
											onChange={ ( val ) => set( 'starter_footer_nav_menu', val ) }
											help={ __( 'เลือกเมนูที่จะแสดงในแถบนำทางด้านล่าง', 'starter-theme' ) }
											style={ { maxWidth: '360px' } }
										/>
									</div>
									<span style={ Object.assign( {}, sectionLabel, { marginTop: '1.5rem' } ) }>{ __( 'ปุ่ม CTA', 'starter-theme' ) }</span>
									<div style={ fieldRow }>
										<ToggleControl
											label={ __( 'แสดงปุ่ม CTA', 'starter-theme' ) }
											checked={ options.starter_footer_cta_enabled === '1' }
											onChange={ ( val ) => set( 'starter_footer_cta_enabled', val ? '1' : '0' ) }
											help={ __( 'แสดง/ซ่อนปุ่มด้านขวาของแถบล่าง', 'starter-theme' ) }
										/>
									</div>
									{ options.starter_footer_cta_enabled === '1' && (
										<div style={ { padding: '1rem 1.25rem', background: '#f9f9f9', borderRadius: '4px', border: '1px solid #dcdcde', marginBottom: '1.25rem' } }>
											<div style={ socialGroup }>
												<div style={ fieldRow }>
													<TextControl
														label={ __( 'ข้อความปุ่ม', 'starter-theme' ) }
														value={ options.starter_footer_cta_text || '' }
														placeholder="สมัครรับข่าวสาร →"
														onChange={ ( val ) => set( 'starter_footer_cta_text', val ) }
													/>
												</div>
												<div style={ fieldRow }>
													<TextControl
														label={ __( 'URL ปุ่ม', 'starter-theme' ) }
														value={ options.starter_footer_cta_url || '' }
														placeholder="https://"
														type="url"
														onChange={ ( val ) => set( 'starter_footer_cta_url', val ) }
													/>
												</div>
											</div>
											<div style={ fieldRow }>
												<ToggleControl
													label={ __( 'เปิดในแท็บใหม่', 'starter-theme' ) }
													checked={ options.starter_footer_cta_external === '1' }
													onChange={ ( val ) => set( 'starter_footer_cta_external', val ? '1' : '0' ) }
												/>
											</div>
										</div>
									) }
									<span style={ sectionLabel }>{ __( 'ลิขสิทธิ์', 'starter-theme' ) }</span>
									<div style={ fieldRow }>
										<TextareaControl
											label={ __( 'ข้อความลิขสิทธิ์', 'starter-theme' ) }
											value={ options.starter_footer_copyright || '' }
											placeholder="สงวนลิขสิทธิ์ © {year} การทางพิเศษแห่งประเทศไทย"
											onChange={ ( val ) => set( 'starter_footer_copyright', val ) }
											help={ __( 'ใช้ {year} สำหรับปี พ.ศ. อัตโนมัติ รองรับ HTML', 'starter-theme' ) }
											rows={ 3 }
										/>
									</div>
								</div>
							) }

						</CardBody>
					</Card>
				) }
			</TabPanel>
		</div>
	);
}

/* ============================================================
   Page: Page Title Settings
   ============================================================ */
function PageTitleSettings() {
	const { options, loading, saving, saved, error, set, save } =
		useThemeOptions();
	const archivePostTypes = [
		{ slug: 'post', label: __( 'บทความ (post)', 'starter-theme' ) },
		{ slug: 'career', label: __( 'ประกาศรับสมัครงาน (career)', 'starter-theme' ) },
		{ slug: 'executive', label: __( 'ผู้บริหาร (executive)', 'starter-theme' ) },
		{ slug: 'annual-report', label: __( 'รายงานประจำปี (annual-report)', 'starter-theme' ) },
		{ slug: 'sustainable-report', label: __( 'รายงานความยั่งยืน (sustainable-report)', 'starter-theme' ) },
		{ slug: 'procurement', label: __( 'จัดซื้อจัดจ้าง (procurement)', 'starter-theme' ) },
	];

	if ( loading ) {
		return (
			<div style={ { margin: '2rem', display: 'flex', alignItems: 'center', gap: '0.75rem' } }>
				<Spinner />
				<span style={ { color: '#50575e' } }>{ __( 'Loading settings…', 'starter-theme' ) }</span>
			</div>
		);
	}

	const openMediaLibrary = ( key ) => {
		const frame = wp.media( {
			title: __( 'Select or Upload Image', 'starter-theme' ),
			button: { text: __( 'Use this image', 'starter-theme' ) },
			multiple: false,
		} );

		frame.on( 'select', () => {
			const attachment = frame.state().get( 'selection' ).first().toJSON();
			set( key, attachment.url );
		} );

		frame.open();
	};

	return (
		<div style={ { maxWidth: '860px' } }>
			<div style={ {
				position: 'sticky',
				top: '32px',
				zIndex: 99,
				background: '#f0f0f1',
				padding: '0.875rem 1.5rem',
				marginBottom: '1.5rem',
				borderRadius: '4px',
				border: '1px solid #dcdcde',
				display: 'flex',
				alignItems: 'center',
				justifyContent: 'space-between',
				gap: '1rem',
			} }>
				<h1 style={ { margin: 0, fontSize: '1rem', fontWeight: 600, color: '#1d2327', whiteSpace: 'nowrap', flexShrink: 0 } }>
					{ __( 'Page Title Settings', 'starter-theme' ) }
				</h1>
				<Flex align="center" gap={ 3 }>
					{ saved && (
						<FlexItem>
							<span style={ { color: '#00a32a', fontWeight: 500, fontSize: '0.875rem', display: 'flex', alignItems: 'center', gap: '0.375rem' } }>
								<span style={ { fontSize: '1rem' } }>✓</span>
								{ __( 'Saved', 'starter-theme' ) }
							</span>
						</FlexItem>
					) }
					<FlexItem>
						<Button
							variant="primary"
							onClick={ save }
							isBusy={ saving }
							disabled={ saving }
							style={ { minWidth: '120px' } }
						>
							{ saving ? __( 'Saving…', 'starter-theme' ) : __( 'Save Settings', 'starter-theme' ) }
						</Button>
					</FlexItem>
				</Flex>
			</div>

			{ error && (
				<Notice status="error" isDismissible onDismiss={ () => {} } style={ { marginBottom: '1rem' } }>
					{ error }
				</Notice>
			) }

			<Card>
				<CardBody style={ { padding: '1.75rem 2rem' } }>
					<span style={ sectionLabel }>{ __( 'ตั้งค่ารูปภาพพื้นหลัง Page Title', 'starter-theme' ) }</span>
					
					<div style={ fieldRow }>
						<BaseControl label={ __( 'รูปภาพพื้นหลังเริ่มต้น', 'starter-theme' ) } help={ __( 'รูปนี้จะแสดงในหน้าต่างๆ ที่ไม่มีภาพหน้าปกเฉพาะ (เช่น Archive, Search)', 'starter-theme' ) }>
							<div style={ { marginTop: '10px' } }>
								{ options.page_title_bg_image && (
									<div style={ { marginBottom: '15px' } }>
										<img 
											src={ options.page_title_bg_image } 
											alt="Preview" 
											style={ { maxWidth: '100%', maxHeight: '200px', borderRadius: '8px', border: '1px solid #dcdcde' } } 
										/>
									</div>
								) }
								<Flex gap={ 2 }>
									<Button variant="secondary" onClick={ () => openMediaLibrary( 'page_title_bg_image' ) }>
										{ options.page_title_bg_image ? __( 'เปลี่ยนรูปภาพ', 'starter-theme' ) : __( 'เลือกรูปภาพ', 'starter-theme' ) }
									</Button>
									{ options.page_title_bg_image && (
										<Button variant="link" isDestructive onClick={ () => set( 'page_title_bg_image', '' ) }>
											{ __( 'ลบรูปภาพ', 'starter-theme' ) }
										</Button>
									) }
								</Flex>
								<div style={ { marginTop: '10px' } }>
									<TextControl
										value={ options.page_title_bg_image || '' }
										onChange={ ( val ) => set( 'page_title_bg_image', val ) }
										placeholder="https://..."
									/>
								</div>
							</div>
						</BaseControl>
					</div>

					<div style={ fieldRow }>
						<BaseControl
							label={ __( 'Archive Header: ตั้งค่าทั่วไป', 'starter-theme' ) }
							help={ __( 'ค่าทั่วไปนี้จะใช้เป็น fallback เมื่อยังไม่ได้กำหนดเฉพาะ post type', 'starter-theme' ) }
						>
							<div style={ { marginTop: '10px' } }>
								<ToggleControl
									label={ __( 'เปิดใช้ภาพพื้นหลังใน Archive Header (ค่าเริ่มต้น)', 'starter-theme' ) }
									checked={ !! options.archive_header_show_bg }
									onChange={ ( val ) => set( 'archive_header_show_bg', val ) }
								/>

								{ options.archive_header_bg_image && (
									<div style={ { marginBottom: '15px' } }>
										<img
											src={ options.archive_header_bg_image }
											alt="Archive Header Preview"
											style={ { maxWidth: '100%', maxHeight: '200px', borderRadius: '8px', border: '1px solid #dcdcde' } }
										/>
									</div>
								) }

								<Flex gap={ 2 }>
									<Button variant="secondary" onClick={ () => openMediaLibrary( 'archive_header_bg_image' ) }>
										{ options.archive_header_bg_image ? __( 'เปลี่ยนรูปภาพ', 'starter-theme' ) : __( 'เลือกรูปภาพ', 'starter-theme' ) }
									</Button>
									{ options.archive_header_bg_image && (
										<Button variant="link" isDestructive onClick={ () => set( 'archive_header_bg_image', '' ) }>
											{ __( 'ลบรูปภาพ', 'starter-theme' ) }
										</Button>
									) }
								</Flex>
								<div style={ { marginTop: '10px' } }>
									<TextControl
										value={ options.archive_header_bg_image || '' }
										onChange={ ( val ) => set( 'archive_header_bg_image', val ) }
										placeholder="https://..."
									/>
								</div>
							</div>
						</BaseControl>
					</div>

					<div style={ fieldRow }>
						<BaseControl
							label={ __( 'Archive Header: แยกตาม Post Type', 'starter-theme' ) }
							help={ __( 'ตั้งค่าภาพหน้าปกเฉพาะแต่ละ post type ได้ โดยจะ override ค่าทั่วไป', 'starter-theme' ) }
						>
							{ archivePostTypes.map( ( item ) => {
								const showKey = `archive_header_show_bg_${ item.slug }`;
								const imageKey = `archive_header_bg_image_${ item.slug }`;

								return (
									<div key={ item.slug } style={ { border: '1px solid #e2e4e7', borderRadius: '8px', padding: '14px', marginBottom: '12px' } }>
										<div style={ { fontWeight: 600, marginBottom: '8px' } }>{ item.label }</div>
										<ToggleControl
											label={ __( 'เปิดใช้ภาพพื้นหลังสำหรับ post type นี้', 'starter-theme' ) }
											checked={ !! options[ showKey ] }
											onChange={ ( val ) => set( showKey, val ) }
										/>

										{ options[ imageKey ] && (
											<div style={ { marginBottom: '12px' } }>
												<img
													src={ options[ imageKey ] }
													alt={ item.label }
													style={ { maxWidth: '100%', maxHeight: '150px', borderRadius: '8px', border: '1px solid #dcdcde' } }
												/>
											</div>
										) }

										<Flex gap={ 2 }>
											<Button variant="secondary" onClick={ () => openMediaLibrary( imageKey ) }>
												{ options[ imageKey ] ? __( 'เปลี่ยนรูปภาพ', 'starter-theme' ) : __( 'เลือกรูปภาพ', 'starter-theme' ) }
											</Button>
											{ options[ imageKey ] && (
												<Button variant="link" isDestructive onClick={ () => set( imageKey, '' ) }>
													{ __( 'ลบรูปภาพ', 'starter-theme' ) }
												</Button>
											) }
										</Flex>

										<div style={ { marginTop: '10px' } }>
											<TextControl
												value={ options[ imageKey ] || '' }
												onChange={ ( val ) => set( imageKey, val ) }
												placeholder="https://..."
											/>
										</div>
									</div>
								);
							} ) }
						</BaseControl>
					</div>
				</CardBody>
			</Card>
		</div>
	);
}

function ExecutiveSettings() {
	const { options, loading, saving, saved, error, set, save } =
		useThemeOptions();
	const [ executives, setExecutives ] = useState( [] );
	const [ search, setSearch ] = useState( '' );
	const [ loadingExecutives, setLoadingExecutives ] = useState( false );

	useEffect( () => {
		setLoadingExecutives( true );
		apiFetch( { path: `/starter_theme/v1/executives?search=${ encodeURIComponent( search ) }` } )
			.then( ( items ) => {
				setExecutives( items || [] );
				setLoadingExecutives( false );
			} )
			.catch( () => {
				setExecutives( [] );
				setLoadingExecutives( false );
			} );
	}, [ search ] );

	if ( loading ) {
		return (
			<div style={ { margin: '2rem', display: 'flex', alignItems: 'center', gap: '0.75rem' } }>
				<Spinner />
				<span style={ { color: '#50575e' } }>{ __( 'Loading settings…', 'starter-theme' ) }</span>
			</div>
		);
	}

	const selectedId = options.executive_governor_post_id || '';
	const executiveOptions = [
		{ value: '', label: __( '— เลือกผู้ว่าการ —', 'starter-theme' ) },
		...executives,
	];

	return (
		<div style={ { maxWidth: '860px' } }>
			<div style={ {
				position: 'sticky',
				top: '32px',
				zIndex: 99,
				background: '#f0f0f1',
				padding: '0.875rem 1.5rem',
				marginBottom: '1.5rem',
				borderRadius: '4px',
				border: '1px solid #dcdcde',
				display: 'flex',
				alignItems: 'center',
				justifyContent: 'space-between',
				gap: '1rem',
			} }>
				<h1 style={ { margin: 0, fontSize: '1rem', fontWeight: 600, color: '#1d2327', whiteSpace: 'nowrap', flexShrink: 0 } }>
					{ __( 'ผู้บริหาร', 'starter-theme' ) }
				</h1>
				<Flex align="center" gap={ 3 }>
					{ saved && (
						<FlexItem>
							<span style={ { color: '#00a32a', fontWeight: 500, fontSize: '0.875rem', display: 'flex', alignItems: 'center', gap: '0.375rem' } }>
								<span style={ { fontSize: '1rem' } }>✓</span>
								{ __( 'Saved', 'starter-theme' ) }
							</span>
						</FlexItem>
					) }
					<FlexItem>
						<Button variant="primary" onClick={ save } isBusy={ saving } disabled={ saving } style={ { minWidth: '120px' } }>
							{ saving ? __( 'Saving…', 'starter-theme' ) : __( 'Save Settings', 'starter-theme' ) }
						</Button>
					</FlexItem>
				</Flex>
			</div>

			{ error && (
				<Notice status="error" isDismissible onDismiss={ () => {} } style={ { marginBottom: '1rem' } }>
					{ error }
				</Notice>
			) }

			<Card>
				<CardBody style={ { padding: '1.75rem 2rem' } }>
					<span style={ sectionLabel }>{ __( 'ตั้งค่าผู้ว่าการสำหรับหน้า Archive ผู้บริหาร', 'starter-theme' ) }</span>
					<div style={ fieldRow }>
						<ComboboxControl
							label={ __( 'ผู้ว่าการ', 'starter-theme' ) }
							value={ selectedId }
							options={ executiveOptions }
							onFilterValueChange={ ( val ) => setSearch( val ) }
							onChange={ ( val ) => set( 'executive_governor_post_id', val ) }
							help={ loadingExecutives ? __( 'กำลังค้นหา...', 'starter-theme' ) : __( 'พิมพ์ชื่อเพื่อค้นหาและเลือกได้เพียง 1 คน คนที่เลือกจะแสดงเป็นการ์ดใหญ่บนสุดของหน้า archive ผู้บริหาร', 'starter-theme' ) }
						/>
					</div>
				</CardBody>
			</Card>
		</div>
	);
}


function ArchiveSettings() {
	const { options, loading, saving, saved, error, set, save } =
		useThemeOptions();

	const postTypes = [
		{ slug: 'post', label: __( 'บทความ (post)', 'starter-theme' ) },
		{ slug: 'career', label: __( 'ประกาศรับสมัครงาน (career)', 'starter-theme' ) },
		{ slug: 'executive', label: __( 'ผู้บริหาร (executive)', 'starter-theme' ) },
		{ slug: 'annual-report', label: __( 'รายงานประจำปี (annual-report)', 'starter-theme' ) },
		{ slug: 'sustainable-report', label: __( 'รายงานเพื่อความยั่งยืน (sustainable-report)', 'starter-theme' ) },
		{ slug: 'procurement', label: __( 'จัดซื้อจัดจ้าง (procurement)', 'starter-theme' ) },
	];

	if ( loading ) {
		return (
			<div style={ { margin: '2rem', display: 'flex', alignItems: 'center', gap: '0.75rem' } }>
				<Spinner />
				<span style={ { color: '#50575e' } }>{ __( 'Loading settings…', 'starter-theme' ) }</span>
			</div>
		);
	}

	return (
		<div style={ { maxWidth: '860px' } }>
			<div style={ {
				position: 'sticky',
				top: '32px',
				zIndex: 99,
				background: '#f0f0f1',
				padding: '0.875rem 1.5rem',
				marginBottom: '1.5rem',
				borderRadius: '4px',
				border: '1px solid #dcdcde',
				display: 'flex',
				alignItems: 'center',
				justifyContent: 'space-between',
				gap: '1rem',
			} }>
				<h1 style={ { margin: 0, fontSize: '1rem', fontWeight: 600, color: '#1d2327', whiteSpace: 'nowrap', flexShrink: 0 } }>
					{ __( 'Archive & Pagination Settings', 'starter-theme' ) }
				</h1>
				<Flex align="center" gap={ 3 }>
					{ saved && (
						<FlexItem>
							<span style={ { color: '#00a32a', fontWeight: 500, fontSize: '0.875rem', display: 'flex', alignItems: 'center', gap: '0.375rem' } }>
								<span style={ { fontSize: '1rem' } }>✓</span>
								{ __( 'Saved', 'starter-theme' ) }
							</span>
						</FlexItem>
					) }
					<FlexItem>
						<Button variant="primary" onClick={ save } isBusy={ saving } disabled={ saving } style={ { minWidth: '120px' } }>
							{ saving ? __( 'Saving…', 'starter-theme' ) : __( 'Save Settings', 'starter-theme' ) }
						</Button>
					</FlexItem>
				</Flex>
			</div>

			{ error && (
				<Notice status="error" isDismissible onDismiss={ () => {} } style={ { marginBottom: '1rem' } }>
					{ error }
				</Notice>
			) }

			<Card>
				<CardBody style={ { padding: '1.75rem 2rem' } }>
					<span style={ sectionLabel }>{ __( 'ตั้งค่ารูปแบบ Pagination แยกตาม Post Type', 'starter-theme' ) }</span>
					<div style={ { display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(360px, 1fr))', gap: '1.5rem' } }>
						{ postTypes.map( ( pt ) => (
							<div key={ pt.slug } style={ { padding: '1.25rem', border: '1px solid #e2e4e7', borderRadius: '12px', background: '#fff' } }>
								<div style={ { fontWeight: 600, marginBottom: '1rem', color: '#1d2327', fontSize: '14px' } }>{ pt.label }</div>
								<SelectControl
									label={ __( 'รูปแบบ Pagination', 'starter-theme' ) }
									value={ options[ `pagination_style_${ pt.slug }` ] || 'full' }
									options={ [
										{ label: __( 'Full (ตัวเลขหน้า 1 2 3 ...)', 'starter-theme' ), value: 'full' },
										{ label: __( 'Compact (แบบใส่เลขหน้า / Jump)', 'starter-theme' ), value: 'compact' },
									] }
									onChange={ ( val ) => set( `pagination_style_${ pt.slug }`, val ) }
								/>
							</div>
						) ) }
					</div>
				</CardBody>
			</Card>
		</div>
	);
}

/* ============================================================

   Mount pages to their DOM roots
   ============================================================ */
const PAGE_MAP = {
	'starter-theme-header-settings-root': HeaderSettings,
	'starter-footer-settings-root': StarterFooterSettings,
	'starter-theme-page-title-settings-root': PageTitleSettings,
	'starter-theme-executive-settings-root': ExecutiveSettings,
	'starter-theme-archive-settings-root': ArchiveSettings,
};

Object.entries( PAGE_MAP ).forEach( ( [ id, Component ] ) => {
	const el = document.getElementById( id );
	if ( el ) {
		createRoot( el ).render( <Component /> );
	}
} );

