import {Button, SelectControl, PanelBody} from '@wordpress/components';
import {MediaUpload, MediaUploadCheck, RichText, InspectorControls} from '@wordpress/block-editor';
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

			if(!!attributes.image.id && parseInt(attributes.image.attributes.width) < parseInt(attributes.image.attributes.height)){
				className += ` ${classNameBase}--tall`;
			}

			return [
				(
					<section className={className}>
						<div className={`${classNameBase}__inner`}>
							<div className={`${classNameBase}__content`}>
								<header className={`${classNameBase}__header`}>
									<BlockTitle
										className={`${classNameBase}__title`}
										tagName='h1'
										title={attributes.title}
										setAttributes={setAttributes}
										/>
								</header>
								<BlockText
									className={`${classNameBase}__text`}
									placeholder={_x('Add text…', 'Field placeholder', 'sha')}
									text={attributes.text}
									setAttributes={setAttributes}
								/>
							</div>
							<LazyImageSelector
								attributes={attributes}
								className={`${classNameBase}__figure`}
								image={attributes.image}
								setAttributes={setAttributes}
							/>
						</div>
					</section>
				)
			];
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
						<header className={`${classNameBase}__header`}>
							<RichText.Content tagName="h1" className={`${classNameBase}__title`} value={ attributes.title } />
						</header>
						{
							!!attributes.text && attributes.text !== '<p></p>' &&
							<RichText.Content
								tagName="div"
								className={`${classNameBase}__text`}
								value={ attributes.text }
								/>
						}
					</div>
					{
						attributes.image && attributes.image.id &&
						<LazyImage className={`${classNameBase}__figure`} image={attributes.image} background={false} admin={false} />
					}
				</div>
			</section>
		);
	}
});
