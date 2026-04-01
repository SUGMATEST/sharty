import React, { useState } from 'react';

interface PostFormProps {
  board: string;
  threadId?: string;
  onSuccess?: () => void;
}

export function PostForm({ board, threadId, onSuccess }: PostFormProps) {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setLoading(true);
    setError(null);

    const form = e.currentTarget;
    const formData = new FormData(form);
    
    // Add required hidden fields for the PHP backend
    formData.append('board', board);
    if (threadId) {
      formData.append('thread', threadId);
    }
    // Tinyboard usually requires the post button value
    formData.append('post', 'Post');
    formData.append('json_response', '1');

    try {
      // @ts-ignore
      if (typeof Module !== 'undefined' && Module.ccall) {
        // @ts-ignore
        const integrityCode = await Module.ccall('x', 'string');
        formData.append('integrity-v2', integrityCode);
      }

      const response = await fetch('/post.php', {
        method: 'POST',
        body: formData,
      });

      const data = await response.json().catch(() => ({ error: 'Invalid JSON response from server' }));

      if (data.error) {
        throw new Error(data.error);
      }
      if (!response.ok) {
        throw new Error('Failed to post');
      }

      form.reset();
      const fileInput = form.querySelector('input[type="file"]') as HTMLInputElement;
      if (fileInput) fileInput.value = '';
      
      // Navigate to the post link if the server provided one
      if (data.redirect) {
        const redirectUrl = new URL(data.redirect, window.location.origin);
        // data.redirect is likely a full path e.g. /b/res/123.html#1234
        // we extract the thread id and post id and redirect through our react router
        const match = redirectUrl.pathname.match(/\/([a-zA-Z0-9_]+)\/(?:res|thread)\/(\d+)/);
        if (match) {
           const [ , destBoard, destThread ] = match;
           const hash = redirectUrl.hash; // e.g. #1234 or #q1234

           if (threadId && destThread === threadId && destBoard === board) {
             // In the same thread, just update hash and trigger onSuccess to silently refresh
             window.location.hash = hash;
             if (onSuccess) onSuccess();
             return;
           }

           // Navigate via window.location to enable hash-jumping gracefully since we haven't configured HashLinks
           window.location.href = `/${destBoard}/thread/${destThread}${hash}`;
           return;
        }
      }

      if (onSuccess) onSuccess();
    } catch (err: any) {
      setError(err.message || 'Error occurred while posting');
    } finally {
      setLoading(false);
    }
  };

  return (
    <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem', maxWidth: '400px', margin: '1rem 0', padding: '1rem', border: '1px solid #ccc', background: '#eef2ff' }}>
      <h3 style={{ margin: '0 0 0.5rem 0' }}>{threadId ? 'Post a Reply' : 'Create New Thread'}</h3>
      {error && <div style={{ color: 'red', fontWeight: 'bold' }}>{error}</div>}
      
      <input name="name" placeholder="Name" />
      <input name="email" placeholder="Email (Options)" />
      <input name="subject" placeholder="Subject" />
      <textarea name="body" placeholder="Comment" required rows={4} />
      
      <div style={{ display: 'flex', gap: '0.5rem', alignItems: 'center' }}>
        <input type="file" name="file" />
      </div>
      
      <input name="password" type="password" placeholder="Password for deletion" />
      
      <button type="submit" disabled={loading} style={{ padding: '0.5rem', fontWeight: 'bold', cursor: 'pointer' }}>
        {loading ? 'Posting...' : 'Post'}
      </button>
    </form>
  );
}
