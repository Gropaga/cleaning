const HOME_SECTION = 'home';

import React from 'react'
import PropTypes from 'prop-types'
import { connect } from 'react-redux'
import Button from 'reactstrap/lib/Button';
import JumbotronLanding from './JumbotronLanding'
import ItemCards from '../ItemCards'
import { _, getLocale } from "../../lib/i18n";
import LinkI18n from "../Helpers/LinkI18n";
import Loading from "../Loading";

import * as actions from "../../actions/common"

import DocumentTitle from "../DocumentTitle";

class Home extends React.Component {
    render() {
        return <DocumentTitle title={ _(HOME_SECTION) }>
            {
                this.props.isFetching || !this.props.updated ?
                    <Loading/> :
                    <div>
                        <JumbotronLanding
                            locale={ getLocale() }
                            image={ this.props.landingImage }
                            jumbo={ this.props.jumbo }
                        />
                        <div className="row home-items">
                            <div className="col-md-12">
                                <h2 className="home-heading">
                                    { _('doors') }
                                    <LinkI18n section="doors">
                                        <Button outline color="primary" size="sm">
                                            { _('door catalogue') }
                                        </Button>
                                    </LinkI18n>
                                    <hr />
                                </h2>
                            </div>
                            <ItemCards
                                locale={ getLocale() }
                                itemSection={'doors'}
                                items={ filterItems(this.props.doors) }
                                selectDimensions={ this.props.selectDimensions('doors') }
                                selectColor={ this.props.selectColor('doors') }
                                history={ this.props.history }
                            />
                        </div>
                        <div className="row home-items">
                            <div className="col-md-12">
                                <h2 className="home-heading">
                                    { _('windows') }
                                    <LinkI18n section="windows">
                                        <Button outline color="primary" size="sm">
                                            { _('window catalogue') }
                                        </Button>
                                    </LinkI18n>
                                    <hr />
                                </h2>
                            </div>
                            <ItemCards
                                locale={ getLocale() }
                                itemSection={'windows'}
                                items={ filterItems(this.props.windows) }
                                selectDimensions={ this.props.selectDimensions('windows') }
                                selectColor={ this.props.selectColor('windows') }
                                history={ this.props.history }
                            />
                        </div>
                        <div className="row home-items">
                            <div className="col-md-12">
                                <h2 className="home-heading">
                                    { _('interiors') }
                                    <LinkI18n section="interiors">
                                        <Button outline color="primary" size="sm">
                                            { _('interior catalogue') }
                                        </Button>
                                    </LinkI18n>
                                    <hr />
                                </h2>
                            </div>
                            <ItemCards
                                locale={ getLocale() }
                                itemSection={'interiors'}
                                items={ filterItems(this.props.interiors) }
                                selectDimensions={ this.props.selectDimensions('interiors') }
                                selectColor={ this.props.selectColor('interiors') }
                                history={ this.props.history }
                            />
                        </div>
                    </div>
            }
        </DocumentTitle>;
    }

    componentWillMount() {
        this.props.requestItems();
    }
}

const filterItems = items => {
    return Object.keys(items)
        .filter(itemId => items[itemId].locale === getLocale())
        .filter(itemId => !!items[itemId].showOnLandingPage)
        .reduce((filteredItems, filteredItemId) => {
            return {
                ...filteredItems,
                [filteredItemId]: items[filteredItemId]
            }
        }, {});
};

Home.propTypes = {
    isFetching: PropTypes.bool,
    requestItems: PropTypes.func.isRequired,
    selectDimensions: PropTypes.func.isRequired,
    selectColor: PropTypes.func.isRequired,
};

const mapStateToProps = state => {
    return {
        isFetching: state.isFetching,
        landingImage: state.home.landingImage,
        doors: state.doors,
        windows: state.windows,
        interiors: state.interiors,
        jumbo: state.home.jumbo,
        updated: state.allLoaded[HOME_SECTION]
    }
};

const mapDispatchToProps = dispatch => ({
    requestItems: () => dispatch(actions.requestAllData(HOME_SECTION)),

    selectDimensions: section => (itemId, dimensions) =>
        dispatch(actions.selectDimensions(section, itemId, dimensions)),

    selectColor: section => (itemId, colorIndex) =>
        dispatch(actions.selectColor(section, itemId, colorIndex))
});

export default connect(mapStateToProps, mapDispatchToProps)(Home)
