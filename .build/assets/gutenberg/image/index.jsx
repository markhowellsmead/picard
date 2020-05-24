import { RichText } from '@wordpress/block-editor';
import { _x } from '@wordpress/i18n';
import { getBlockDefaultClassName, registerBlockType } from '@wordpress/blocks';

import { LazyImage } from '../_vendor/lazyimage.jsx';
import edit from './edit.jsx';

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
		figcaption: {
			type: 'string',
			default: ''
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
		},
		textColor: {
			type: 'string',
			default: ''
		},
	},
	edit,
	save( { attributes } ) {
		let className = getBlockDefaultClassName( 'mhm/image' );
		const classNameBase = getBlockDefaultClassName( 'mhm/image' );

		if ( !!attributes.image.id && parseInt( attributes.image.attributes.width ) < parseInt( attributes.image.attributes.height ) ) {
			className += ` ${ className }--tall`;
		}

		let style = {};

		if(!!attributes.textColor){
			style.color = attributes.textColor;
		}

		return (
			<section className={`${className} ${attributes.ratio}`} style={style}>
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
				{
					!!attributes.figcaption &&
					<RichText.Content
						style={style}
						tagName="figcaption"
						className={`${classNameBase}__figcaption`}
						value={ attributes.figcaption }
						/>
				}
			</section>
		);
	}
} );
