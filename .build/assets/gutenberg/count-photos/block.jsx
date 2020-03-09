const { _x } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { ServerSideRender } = wp.components;
const { Component } = wp.element;

registerBlockType("mhm/count-posts", {
	title: _x("Number of posts", "Block title", "sha"),
	icon: "image-flip-horizontal",
	category: "widgets",
	supports: {
		mode: false,
		html: false,
		multiple: true,
		reusable: true
	},
	keywords: ["count", "posts"],
	edit: class extends Component {
		render() {
			return <ServerSideRender block="mhm/count-posts" />;
		}
	},
	save() {
		return null;
	}
});
