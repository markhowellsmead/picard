const { Component } = wp.element;
const { select, subscribe } = wp.data;

export default class Edit extends Component {
	constructor(props) {
		super(props);
		this.state = {
			excerpt: ""
		};
		this.unsubscribe = () => {};
	}

	componentDidMount() {
		this.unsubscribe = subscribe(() => {
			const excerpt = select("core/editor").getEditedPostAttribute(
				"excerpt"
			);
			if (excerpt !== this.state.excerpt) {
				this.setState({
					excerpt
				});
			}
		});
	}

	componentWillUnmount() {
		this.unsubscribe();
	}

	render() {
		const { state } = this;
		const { className, attributes } = this.props;
		return (
			<section className={className}>
				{state.excerpt && <p>{state.excerpt}</p>}
				{!state.excerpt && (
					<p>
						<em>No excerpt</em>
					</p>
				)}
			</section>
		);
	}
}
