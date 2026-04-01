import { useEffect, useState, useCallback } from 'react';
import { useParams, Link } from 'react-router-dom';
import { fetchThread } from '../api/client';
import { PostForm } from '../components/PostForm';

export function Thread() {
  const { board, threadId: rawThreadId } = useParams<{ board: string; threadId: string }>();
  const threadId = rawThreadId?.replace(/\.html$/, '');
  const [thread, setThread] = useState<any>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const loadThread = useCallback((silent: boolean = false) => {
    if (!board || !threadId) return;
    if (!silent) setLoading(true);
    fetchThread(board, parseInt(threadId, 10))
      .then((data) => {
        setThread(data.posts);
        setLoading(false);
      })
      .catch((err) => {
        if (!silent) setError(err.message);
        setLoading(false);
      });
  }, [board, threadId]);

  useEffect(() => {
    loadThread();
    const interval = setInterval(() => {
      loadThread(true);
    }, 5000);
    return () => clearInterval(interval);
  }, [loadThread]);

  const handlePostSuccess = () => {
    loadThread(true);
    setTimeout(() => {
      window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    }, 500); // Give it a moment to render the new post
  };

  if (loading) return <div>Loading /{board}/{threadId}...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <div>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
        <h1>Thread: {threadId}</h1>
        <Link to={`/${board}/`}>[Return to Catalog]</Link>
      </div>

      <div style={{ display: 'flex', justifyContent: 'center', marginBottom: '2rem' }}>
        <PostForm board={board!} threadId={threadId} onSuccess={handlePostSuccess} />
      </div>

      <div className="thread-posts" style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
        {thread?.map((post: any) => (
          <div key={post.no} id={post.no} className="post" style={{ border: '1px solid #aaa', padding: '1rem', background: '#f4f4f4' }}>
            <div className="post-header">
              <span className="post-name"><b>{post.name || 'Anonymous'}</b></span>
              <span className="post-date"> {new Date(post.time * 1000).toLocaleString()} </span>
              <span className="post-no">No. {post.no}</span>
            </div>
            {post.filename && post.pending_approval !== 1 && (
              <div className="post-file" style={{ marginBottom: '1rem' }}>
                <a href={`/${board}/src/${post.tim}${post.ext}`} target="_blank" rel="noreferrer">
                  <img src={`/${board}/thumb/${post.thumb}`} alt={post.filename} style={{ maxWidth: 200, float: 'left', marginRight: 10 }} />
                </a>
              </div>
            )}
            {post.filename && post.pending_approval === 1 && (
              <div className="post-file" style={{ marginBottom: '1rem', width: 200, height: 200, background: '#ccc', float: 'left', marginRight: 10, display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                [Pending Approval]
              </div>
            )}
            <div className="post-body" dangerouslySetInnerHTML={{ __html: post.com }}></div>
            <div style={{ clear: 'both' }}></div>
          </div>
        ))}
      </div>
      
      <div style={{ display: 'flex', justifyContent: 'center', marginTop: '2rem' }}>
        <PostForm board={board!} threadId={threadId} onSuccess={handlePostSuccess} />
      </div>
    </div>
  );
}
