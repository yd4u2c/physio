body {
  font: 12px "Helvetica Neue", helvetica, arial, sans-serif;
  color: #131313;
  background: #eeeeee;
  padding:0;
  margin: 0;
  max-height: 100%;

  text-rendering: optimizeLegibility;
}
  a {
    text-decoration: none;
  }

.panel {
    overflow-y: scroll;
    height: 100%;
    position: fixed;
    margin: 0;
    left: 0;
    top: 0;
}

.branding {
  position: absolute;
  top: 10px;
  right: 20px;
  color: #777777;
  font-size: 10px;
    z-index: 100;
}
  .branding a {
    color: #e95353;
  }

header {
  color: white;
  box-sizing: border-box;
  background-color: #2a2a2a;
  padding: 35px 40px;
  max-height: 180px;
  overflow: hidden;
  transition: 0.5s;
}

  header.header-expand {
    max-height: 1000px;
  }

  .exc-title {
    margin: 0;
    color: #bebebe;
    font-size: 14px;
  }
    .exc-title-primary, .exc-title-secondary {
      color: #e95353;
    }

    .exc-message {
      font-size: 20px;
      word-wrap: break-word;
      margin: 4px 0 0 0;
      color: white;
    }
      .exc-message span {
        display: block;
      }
      .exc-message-empty-notice {
        color: #a29d9d;
        font-weight: 300;
      }

.prev-exc-title {
  margin: 10px 0;
}

.prev-exc-title + ul {
  margin: 0;
  padding: 0 0 0 20px;
  line-height: 12px;
}

.prev-exc-title + ul li {
  font: 12px "Helvetica Neue", helvetica, arial, sans-serif;
}

.prev-exc-title + ul li .prev-exc-code {
  display: inline-block;
  color: #bebebe;
}

.details-container {
  left: 30%;
  width: 70%;
  background: #fafafa;
}
  .details {
    padding: 5px;
  }

    .details-heading {
      color: #4288CE;
      font-weight: 300;
      padding-bottom: 10px;
      margin-bottom: 10px;
      border-bottom: 1px solid rgba(0, 0, 0, .1);
    }

    .details pre.sf-dump {
      white-space: pre;
      word-wrap: inherit;
    }

    .details pre.sf-dump,
    .details pre.sf-dump .sf-dump-num,
    .details pre.sf-dump .sf-dump-const,
    .details pre.sf-dump .sf-dump-str,
    .details pre.sf-dump .sf-dump-note,
    .details pre.sf-dump .sf-dump-ref,
    .details pre.sf-dump .sf-dump-public,
    .details pre.sf-dump .sf-dump-protected,
    .details pre.sf-dump .sf-dump-private,
    .details pre.sf-dump .sf-dump-meta,
    .details pre.sf-dump .sf-dump-key,
    .details pre.sf-dump .sf-dump-index {
      color: #463C54;
    }

.left-panel {
  width: 30%;
  background: #ded8d8;
}

  .frames-description {
    background: rgba(0, 0, 0, .05);
    padding: 8px 15px;
    color: #a29d9d;
    font-size: 11px;
  }

  .frames-description.frames-description-application {
    text-align: center;
    font-size: 12px;
  }
  .frames-container.frames-container-application .frame:not(.frame-application) {
    display: none;
  }

  .frames-tab {
    color: #a29d9d;
    display: inline-block;
    padding: 4px 8px;
    margin: 0 2px;
    border-radius: 3px;
  }

  .frames-tab.frames-tab-active {
    background-color: #2a2a2a;
    color: #bebebe;
  }

  .frame {
    padding: 14px;
    cursor: pointer;
    transition: all 0.1s ease;
    background: #eeeeee;
  }
    .frame:not(:last-child) {
      border-bottom: 1px solid rgba(0, 0, 0, .05);
    }

    .frame.active {
      box-shadow: inset -5px 0 0 0 #4288CE;
      color: #4288CE;
    }

    .frame:not(.active):hover {
      background: #BEE9EA;
    }

    .frame-method-info {
      margin-bottom: 10px;
    }

    .frame-class, .frame-function, .frame-index {
      font-size: 14px;
    }

    .frame-index {
      float: left;
    }

    .frame-method-info {
      margin-left: 24px;
    }

    .frame-index {
      font-size: 11px;
      color: #a29d9d;
      background-color: rgba(0, 0, 0, .05);
      height: 18px;
      width: 18px;
      line-height: 18px;
      border-radius: 5px;
      padding: 0 1px 0 1px;
      text-align: center;
      display: inline-block;
    }

    .frame-application .frame-index {
      background-color: #2a2a2a;
      color: #bebebe;
    }

    .frame-file {
      font-family: "Inconsolata", "Fira Mono", "Source Code Pro", Monaco, Consolas, "Lucida Console", monospace;
      color: #a29d9d;
    }

      .frame-file .editor-link {
        color: #a29d9d;
      }

    .frame-line {
      font-weight: bold;
    }

    .frame-line:before {
      content: ":";
    }

    .frame-code {
      padding: 5px;
      background: #303030;
      display: none;
    }

    .frame-code.active {
      display: block;
    }

    .frame-code .frame-file {
      color: #a29d9d;
      padding: 12px 6px;

      border-bottom: none;
    }

    .code-block {
      padding: 10px;
      margin: 0;
      border-radius: 6px;
      box-shadow: 0 3px 0 rgba(0, 0, 0, .05),
                  0 10px 30px rgba(0, 0, 0, .05),
                  inset 0 0 1px 0 rgba(255, 255, 255, .07);
      -moz-tab-size: 4;
      -o-tab-size: 4;
      tab-size: 4;
    }

    .linenums {
      margin: 0;
      margin-left: 10px;
    }

    .frame-comments {
      border-top: none;
      margin-top: 15px;

      font-size: 12px;
    }

    .frame-comments.empty {
    }

    .frame-comments.empty:before {
      content: "No comments for this stack frame.";
      font-weight: 300;
      color: #a29d9d;
    }

    .frame-comment {
      padding: 10px;
      color: #e3e3e3;
      border-radius: 6px;
      background-color: rgba(255, 255, 255, .05);
    }
      .frame-comment a {
        font-weight: bold;
        text-decoration: none;
      }
        .frame-comment a:hover {
          color: #4bb1b1;
        }

    .frame-comment:not(:last-child) {
      border-bottom: 1px dotted rgba(0, 0, 0, .3);
    }

    .frame-comment-context {
      font-size: 10px;
      color: white;
    }

.delimiter {
  display: inline-block;
}

.data-table-container label {
  font-size: 16px;
  color: #303030;
  font-weight: bold;
  margin: 10px 0;

  display: block;

  margin-bottom: 5px;
  padding-bottom: 5px;
}
  .data-table {
    width: 100%;
    margin-bottom: 10px;
  }

  .data-table tbody {
    font: 13px "Inconsolata", "Fira Mono", "Source Code Pro", Monaco, Consolas, "Lucida Console", monospace;
  }

  .data-table thead {
    display: none;
  }

  .data-table tr {
    padding: 5px 0;
  }

  .data-table td:first-child {
    width: 20%;
    min-width: 130px;
    overflow: hidden;
    font-weight: bold;
    color: #463C54;
    padding-right: 5px;

  }

  .data-table td:last-child {
    width: 80%;
    -ms-word-break: break-all;
    word-break: brea