import { createBlock } from '@wordpress/blocks';
import { SelectControl, PanelBody, FocalPointPicker } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import { select } from '@wordpress/data';
import { Fragment, Component } from '@wordpress/element';
import { _x } from '@wordpress/i18n';
import { getBlockDefaultClassName, registerBlockType } from '@wordpress/blocks';

import LazyImageSelector from '../_vendor/lazyimageselector.jsx';
import { LazyImage } from '../_vendor/lazyimage.jsx';
import { BlockTitle } from '../_components/blocktitles.jsx';
import { BlockText } from '../_components/blocktext.jsx';

registerBlockType( 'mhm/image', {
	title: _x( 'Custom image block', 'Block title', 'sha' ),
	icon: 'format-image',
	category: 'widgets',
	keywords: [
		'image', 'gallery'
	],
	supports: {
		align: [
			'wide', 'full'
		],
		html: false,
		inserter: true
	},
	attributes: {
		image: {
			type: 'Object',
			default: {
				id: false
			}
		},
		focalPoint: {
			type: 'Object',
			default: {
				x: 0.5,
				y: 0.5
			}
		},
		ratio: {
			type: 'string',
			default: 'is-aspect--3x2'
		}
	},
	edit: class extends Component {

		constructor( props ) {
			super( ...arguments );
			this.props = props;
		}

		render() {

			const { attributes, setAttributes } = this.props;
			let classNameBase = getBlockDefaultClassName( 'mhm/image-set' );
			let className = this.props.className;

			if ( !!attributes.image.id && parseInt( attributes.image.attributes.width ) < parseInt( attributes.image.attributes.height ) ) {
				className += ` ${ classNameBase }--tall`;
			}

			let imageData = !!attributes.image.id ? select( 'core' ).getMedia( attributes.image.id ) : null;

			return (
				<Fragment>
					<InspectorControls>
						<PanelBody title="Layout settings" initialOpen={true}>
							<SelectControl
								label="Select image proportions"
								value={attributes.ratio}
								options={[
									{
										label: '3 x 2',
										value: 'is-aspect--3x2'
									}, {
										label: '4 x 3',
										value: 'is-aspect--4x3'
									}, {
										label: '5 x 4',
										value: 'is-aspect--5x4'
									}, {
										label: '16 x 9',
										value: 'is-aspect--16_9'
									}, {
										label: '2.5:1',
										value: 'is-aspect--25_10'
									}, {
										label: '3:1',
										value: 'is-aspect--3x1'
									}, {
										label: '4:1',
										value: 'is-aspect--4x1'
									}, {
										label: '2 x 3',
										value: 'is-aspect--2x3'
									}, {
										label: '3 x 4',
										value: 'is-aspect--3x4'
									}, {
										label: '4 x 5',
										value: 'is-aspect--4x5'
									}
								]} onChange={value => {
									setAttributes( { ratio: value } );
								}}/>
								{
									imageData && imageData.media_details &&
									<FocalPointPicker
										url={ imageData.media_details.sizes.full.source_url }
										dimensions={ {
											width: imageData.media_details.sizes.full.width,
											height: imageData.media_details.sizes.full.height
										} }
										value={ attributes.focalPoint }
										onChange={ ( newFocalPoint ) => setAttributes( { focalPoint: newFocalPoint } ) }
									/>
								}
						</PanelBody>
					</InspectorControls>
					<section className={`${className} ${attributes.ratio}`}>
						<LazyImageSelector
							attributes={attributes}
							className={`${ classNameBase }__figure`}
							image={attributes.image}
							setAttributes={setAttributes}
							objectFocalPoint={attributes.focalPoint}
						/>
					</section>
				</Fragment>
			);
		}
	},
	save( { attributes } ) {
		let className = getBlockDefaultClassName( 'mhm/image' );
		const classNameBase = getBlockDefaultClassName( 'mhm/image' );

		if ( !!attributes.image.id && parseInt( attributes.image.attributes.width ) < parseInt( attributes.image.attributes.height ) ) {
			className += ` ${ className }--tall`;
		}

		return ( <section className={`${className} ${attributes.ratio}`}>
			{
				!!attributes.image.id &&
				<LazyImage
					className={`${ classNameBase }__figure`}
					image={attributes.image}
					background={false}
					admin={false}
					objectFocalPoint={attributes.focalPoint}
				/>
			}
		</section> );
	}
} );
