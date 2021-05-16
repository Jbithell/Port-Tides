import * as React from "react";
import Layout from "../components/Layout.js";

const NotFoundPage = () => {
  const lang = (typeof window !== "undefined" && location.pathname.includes("/cy") ? "cy" : "en");
  return (
    <Layout lang="en">
      <div className="w-screen text-center mt-20 pb-50 px-4 text-5xl">
        {lang == "en" ?
          "404 - Page not found"
          :
          "404 - Tudalen heb ei darganfod"
        }
      </div>
    </Layout>
  );
};

export default NotFoundPage;
