import { createBlock } from '@wordpress/blocks';
import { SelectControl, PanelBody } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
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
									}
								]} onChange={value => {
									setAttributes( { ratio: value } );
								}}/>
						</PanelBody>
					</InspectorControls>
					<section className={`${className} ${attributes.ratio}`}>
						<LazyImageSelector
							attributes={attributes}
							className={`${ classNameBase }__figure`}
							image={attributes.image}
							setAttributes={setAttributes}
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
				/>
			}
		</section> );
	}
} );
