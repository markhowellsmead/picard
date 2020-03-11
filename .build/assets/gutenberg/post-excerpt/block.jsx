const { _x } = wp.i18n;
const { registerBlockType } = wp.blocks;

import edit from "./edit";

registerBlockType("mhm/post-excerpt", {
	title: _x("Post excerpt", "Block title", "sha"),
	icon: "excerpt-view",
	category: "widgets",
	supports: {
		mode: false,
		html: false
	},
	attributes: {
		excerpt: {
			type: "string",
			default: ""
		}
	},
	keywords: ["excerpt"],
	edit,
	save() {
		return null;
	}
});
