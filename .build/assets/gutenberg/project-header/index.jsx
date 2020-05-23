import {Button, SelectControl, PanelBody, FocalPointPicker} from '@wordpress/components';
import {InnerBlocks, RichText, InspectorControls} from '@wordpress/block-editor';
import {select} from '@wordpress/data';
import {Fragment, Component} from '@wordpress/element';
import {__, _x} from '@wordpress/i18n';
import {getBlockDefaultClassName, registerBlockType} from '@wordpress/blocks';

import LazyImageSelector from '../_vendor/lazyimageselector.jsx';
import { LazyImage } from '../_vendor/lazyimage.jsx';
import { BlockTitle } from '../_components/blocktitles.jsx';
import { BlockText } from '../_components/blocktext.jsx';

registerBlockType('mhm/project-header', {
	title: _x('Project header', 'Block title', 'sha'),
	icon: 'layout',
	category: 'widgets',
	keywords: [
		_x('Header', 'Gutenberg block keyword', 'sha')
	],
	supports: {
		align: ['wide', 'full'],
		html: false,
		inserter: true
	},
	styles: [
		{ name: 'default', label: _x( 'Default', 'block style', 'sha' ), isDefault: true },
		{ name: 'flipped', label: _x( 'Flipped', 'block style', 'sha' ) },
	],
	attributes: {
		focalPoint: {
			type: 'Object',
			default: {
				x: 0.5,
				y: 0.5
			}
		},
		title: {
			type: 'string',
			default: ''
		},
		text: {
			type: 'string',
			default: ''
		},
		image: {
			type: 'Object',
			default: {
				id: false,
			}
		},
		ratio: {
			type: 'string',
			default: 'is-aspect--3x2'
		}
	},

	edit: class extends Component {

		constructor(props) {
			super(...arguments);
			this.props = props;
		}

		render() {

			const { attributes, setAttributes } = this.props;
			let classNameBase = getBlockDefaultClassName( 'mhm/project-header' );
			let className = this.props.className;

			let imageData = !!attributes.image.id ? select( 'core' ).getMedia( attributes.image.id ) : null;

			if(!!attributes.image.id && parseInt(attributes.image.attributes.width) < parseInt(attributes.image.attributes.height)){
				className += ` ${classNameBase}--tall`;
			}

			return (
				<Fragment>
					{
						imageData && imageData.media_details &&
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
								<FocalPointPicker
									url={ imageData.media_details.sizes.full.source_url }
									dimensions={ {
										width: imageData.media_details.sizes.full.width,
										height: imageData.media_details.sizes.full.height
									} }
									value={ attributes.focalPoint }
									onChange={ ( newFocalPoint ) => setAttributes( { focalPoint: newFocalPoint } ) }
								/>
							</PanelBody>
						</InspectorControls>
					}
					<section className={`${className} ${attributes.ratio}`}>
						<div className={`${classNameBase}__inner`}>
							<div className={`${classNameBase}__content`}>
								<InnerBlocks
									allowedBlocks={(['core/heading'], ['core/paragraph'])}
									template={[
										['core/heading', {
											'level': 1
										}],
										['core/paragraph']
									]}
								/>
							</div>
							<div className={`${className}__figurewrap ${attributes.ratio}`}>
								<LazyImageSelector
									attributes={attributes}
									className={`${classNameBase}__figure`}
									image={attributes.image}
									setAttributes={setAttributes}
									objectFocalPoint={attributes.focalPoint}
									admin={true}
								/>
							</div>
						</div>
					</section>
				</Fragment>
			);
		}
	},
	save({ attributes }){
		let className = getBlockDefaultClassName( 'mhm/project-header' );
		const classNameBase = getBlockDefaultClassName( 'mhm/project-header' );

		if(!!attributes.image.id && parseInt(attributes.image.attributes.width) < parseInt(attributes.image.attributes.height)){
			className += ` ${className}--tall`;
		}

		return(
			<section className={className}>
				<div className={`${classNameBase}__inner`}>
					<div className={`${classNameBase}__content`}>
						<InnerBlocks.Content />
					</div>
					{
						!!attributes.image.id &&
						<div className={`${className}__figurewrap ${attributes.ratio}`}>
							<LazyImage
								className={`${classNameBase}__figure`}
								image={attributes.image}
								background={false}
								admin={false}
								objectFocalPoint={attributes.focalPoint}
								/>
						</div>
					}
				</div>
			</section>
		);
	}
});
