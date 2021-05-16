import * as React from "react";
import Layout from "../components/Layout.js";
import Tides from "../components/Tides.js";
import PDFs from "../components/PDFs.js";
const IndexPage = () => {
  return (
    <Layout lang="cy">
      <Tides lang="cy" />
      <PDFs lang="cy" historical={false} />
    </Layout>
  );
};

export default IndexPage;
