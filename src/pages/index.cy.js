import * as React from "react";
import Header from "../components/Header.js";
import Tides from "../components/Tides.js";
import Footer from "../components/Footer.js";

const IndexPage = () => {
  return (
    <>
      <Header lang="cy" />
      <Tides lang="cy" />
      <Footer lang="cy" />
    </>
  );
};

export default IndexPage;
