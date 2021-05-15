import * as React from "react";

const Footer = (props) => {
  return (
    <>
      {props.lang == "en" ? "Footer":"Welsh Footer"}
    </>
  );
};

export default Footer;
