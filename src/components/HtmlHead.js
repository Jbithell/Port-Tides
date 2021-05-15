import * as React from "react";
import PropTypes from "prop-types";
import { Helmet } from "react-helmet";

const HtmlHead = (props) => {
  return (
    <>
      <Helmet htmlAttributes={{ lang: props.lang }}>
        <meta charSet="utf-8" />
        
        <title>{props.title}</title>
        <link rel="canonical" href={props.canonical} />
        <meta name="description" content={props.description} />
        {props.image && <meta name="image" content={props.image} />}
        <meta property="og:title" content={props.title} />
        <meta property="og:description" content={props.description} />
      </Helmet>
    </>
  );
};


HtmlHead.propTypes  = {
  title: PropTypes.string,
  image: PropTypes.bool,
  canonical: PropTypes.string,
  description: PropTypes.string,
  lang: PropTypes.string
};
HtmlHead.defaultProps = {
  title: "Porthmadog Tide Times",
  image: false,
  canonical: "https://port-tides.com",
  description: "Free tidal predictions for the seaside town of Porthmadog and its beautiful estuary. The best place to get tide times for Porthmadog, Borth-y-gest, Morfa Bychan and Black rock sands",
  lang: "en"
};

export default HtmlHead;
