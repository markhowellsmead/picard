// import "./image-gallery/block.jsx";
import "./blog-cards/index.jsx";
import "./count-photos/index.jsx";
import "./count-posts/index.jsx";
import "./footnotes/index.jsx";
import "./language-excerpt/index.jsx";
import "./post-excerpt/index.jsx";
import "./post-header/index.jsx";
import "./shb-video-bar/index.jsx";
import "./years-online/index.jsx";

window.onload = function () {
	window.shtDisabledBlocks.forEach(block => {
		wp.blocks.unregisterBlockType(block);
	});
};

wp.domReady(() => {
	wp.blocks.registerBlockStyle("core/cover", {
		name: "aspect-21",
		label: "2:1",
	});
	wp.blocks.registerBlockStyle("core/cover", {
		name: "aspect-43",
		label: "4:3",
	});
	wp.blocks.registerBlockStyle("core/cover", {
		name: "aspect-45",
		label: "4:5",
	});
	wp.blocks.registerBlockStyle("core/cover", {
		name: "aspect-32",
		label: "3:2",
	});
	wp.blocks.registerBlockStyle("core/cover", {
		name: "aspect-251",
		label: "2.5:1",
	});
	wp.blocks.registerBlockStyle("core/cover", {
		name: "aspect-31",
		label: "3:1",
	});
	wp.blocks.registerBlockStyle("core/cover", {
		name: "aspect-41",
		label: "4:1",
	});
	wp.blocks.registerBlockStyle("core/cover", {
		name: "aspect-169",
		label: "16:9",
	});
	wp.blocks.registerBlockStyle("core/cover", {
		name: "full-height",
		label: "Full height",
	});
	wp.blocks.registerBlockStyle("core/paragraph", {
		name: "lead",
		label: "Lead text",
	});
	wp.blocks.registerBlockStyle("shb/video-bar", {
		name: "fullheight",
		label: "Full screen height",
	});

	wp.blocks.registerBlockStyle("core/group", {
		name: "padding",
		label: "Vertical padding",
	});

	wp.blocks.registerBlockStyle("core/group", {
		name: "padding--medium",
		label: "Vertical padding (medium)",
	});

	wp.blocks.registerBlockStyle("core/group", {
		name: "padding--large",
		label: "Vertical padding (large)",
	});

	wp.blocks.registerBlockStyle("core/group", {
		name: "padding--xlarge",
		label: "Vertical padding (xlarge)",
	});

	wp.blocks.registerBlockStyle("core/button", {
		name: "xsmall",
		label: "x-small",
	});

	wp.blocks.registerBlockStyle("core/button", {
		name: "small",
		label: "Small",
	});

	wp.blocks.registerBlockStyle("core/button", {
		name: "medium",
		label: "Medium",
	});

	wp.blocks.registerBlockStyle("core/button", {
		name: "large",
		label: "Large",
	});

});
